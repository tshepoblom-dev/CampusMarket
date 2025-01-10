<script>
    let settingProductDate = ["<?php echo $settingProductDate; ?>"];
    let purchaseOrderDate = ["<?php echo $purchaseOrderDate; ?>"];
    let orderSummeryDate = ["<?php echo $orderSummeryDate; ?>"];
    let orderSummeryQty = ["<?php echo $orderSummeryQty; ?>"];
    let customerDate = ["<?php echo $customerDate; ?>"];
    let merchantTotal = ["<?php echo $merchantTotal; ?>"];
    let customerTotal = ["<?php echo $customerTotal; ?>"];

    let widthdrawMonth = ["<?php echo $widthdrawMonth; ?>"];
    let depositMonth = ["<?php echo $depositMonth; ?>"];
    let bidOrderAmount = ["<?php echo $bidOrderAmount; ?>"];

    (function($) {
        "use strict";

        const order_summery = document.getElementById('order_summery');
        const order_auction_direct_product = document.getElementById('order_auction_direct_product');

        const customer_merchant = document.getElementById('customer_merchant');
        const disposit_widthdraw = document.getElementById('disposit_widthdraw');

        const product_selling = document.getElementById('product_selling');

        //================== order summery js configuar start

        const orderdata = {
            labels: orderSummeryDate,
            datasets: [{
                label: 'Order Summery',
                data: orderSummeryQty,
                borderColor: 'rgba(54, 162, 235,1)',
                backgroundColor: 'rgba(54, 162, 235,0.5)',
                pointStyle: 'circle',
                pointRadius: 10,
                pointHoverRadius: 15
            }]
        };

        const orderconfig = {
            type: 'line',
            data: orderdata,
            options: {
                responsive: true,

            }
        };

        new Chart(order_summery, orderconfig);

        //================== order summery js configuar end

        //================== auction and direct chart js configuar start


        const auctionDirectData = {
            labels: purchaseOrderDate,
            datasets: [{
                    label: 'Auction Sale',
                    data:bidOrderAmount,
                    borderColor: 'rgba(255, 99, 132,1)',
                    backgroundColor: 'rgba(255, 99, 132,0.5)',
                },
                {
                    label: 'Direct Sale',
                    data: [{{ $purchaseOrderAmount }}],
                    borderColor: 'rgba(54, 162, 235,1)',
                    backgroundColor: 'rgba(54, 162, 235,0.5)',
                }
            ]
        };

        const auctionDirectConfig = {
            type: 'line',
            data: auctionDirectData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },

                }
            },
        };

        new Chart(order_auction_direct_product, auctionDirectConfig);

        //================== auction and direct chart js configuar end

        const datad = {
            labels: settingProductDate,
            datasets: [{
                label: 'Product Sale',
                data: [{{ $daySales }}],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
            }]
        };

        const config = {
            type: 'line',
            data: datad,
            options: {
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: true
                    }
                },
                scales: {
                    y: { // defining min and max so hiding the dataset does not change scale range
                        min: 0,
                        max: 100
                    }
                }
            }
        };


        new Chart(product_selling, config);


        //================== customer and merchant chart js configuar start

        const customerMerchants = {
            labels: customerDate,
            datasets: [{
                    label: 'Merchants',
                    data: merchantTotal,
                    borderColor: 'rgba(54, 162, 235,1)',
                    backgroundColor: 'rgba(54, 162, 235,0.5)',
                    stack: 'combined',
                    type: 'bar'
                },
                {
                    label: 'Customers',
                    data: customerTotal,
                    borderColor: 'rgba(255, 99, 132,1)',
                    backgroundColor: 'rgba(255, 99, 132,0.5)',
                    stack: 'combined'
                }
            ]
        };


        const customerMerchantsConfig = {
            type: 'line',
            data: customerMerchants,
            options: {

                scales: {
                    y: {
                        stacked: true
                    }
                }
            },
        };

        new Chart(customer_merchant, customerMerchantsConfig);


        //================== customer and merchant chart js configuar end


        //================== deposit and widthdraw chart js configuar start

        const depostiWidthdrawData = {
            labels: depositMonth,
            datasets: [{
                    label: 'Deposit',
                    data: [{{ $depositSum }}],
                    borderColor: 'rgb(75, 192, 192)',
                },
                {
                    label: 'Widthdraw ',
                    data: [{{ $widthdrawSum }}],
                    borderColor: 'rgba(255, 99, 132,1)',
                }
            ]
        };

        const depostiWidthdrawConfig = {
            type: 'line',
            data: depostiWidthdrawData,
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,

                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',

                        // grid line settings
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    },
                }
            },
        };

        new Chart(disposit_widthdraw, depostiWidthdrawConfig);

        //================== deposit and widthdraw chart js configuar end

    })(jQuery);
</script>
