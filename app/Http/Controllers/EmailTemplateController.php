<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Validator;


class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin','pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = translate('Email Template');
        $email_templates = EmailTemplate::where('status', 1)->get();
        return view('backend.email_template.index', compact('page_title', 'email_templates'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page_title = translate('Edit Email Template');
        $emailTemplateSingle = EmailTemplate::findOrFail($id);
        return view('backend.email_template.edit', compact('page_title', 'emailTemplateSingle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $content = $request->body;
        $dom = new \DomDocument();
        @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            if (isset(explode(';', $data)[1])) {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $imgeData = base64_decode($data);
                $image_name = "/uploads/email/" . time() . $item . '.png';
                $path = public_path() . $image_name;
                file_put_contents($path, $imgeData);

                $image->removeAttribute('src');
                $image->setAttribute('src', $image_name);
            }
        }

        $content = $dom->saveHTML();
        $emailTemplate = EmailTemplate::findOrFail($id);
        $emailTemplate->name = $request->name;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->body = str_replace('script', '', prelaceScript(html_entity_decode($content)));
        $emailTemplate->update();

        return redirect()->route('email.template.list')->with('success', translate('Email Template updated successfully'));
    }


}
