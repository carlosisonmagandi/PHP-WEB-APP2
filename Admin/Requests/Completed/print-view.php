<?php 
$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$queryString = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

$id = $queryString;
$hasId = !empty($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Product Apprehension Record</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            /* background-color: #f4f4f4; */
            justify-content: center;
            align-items: center;

           
        }
        
        .parent {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: repeat(15, 1fr);
            gap: 2px;
            background-color: #FFF;
        }
        
        /* Your existing div styles */
        .div2 { grid-column-start: 2; grid-row-start: 3; }
        .div3 { grid-column-start: 2; grid-row-start: 4; }
        .div4 { grid-column-start: 2; grid-row-start: 5; }
        .div5 { grid-column-start: 2; grid-row-start: 6; }
        .div6 { grid-column-start: 2; grid-row-start: 7; }
        .div7 { grid-column-start: 2; grid-row-start: 8; }
        .div8 { grid-column-start: 2; grid-row-start: 9; }
        .div9 { grid-column-start: 2; grid-row-start: 10; }
        .div10 { grid-column-start: 2; grid-row-start: 11;  }
        .div11 { grid-column-start: 2; grid-row-start: 12; }
        .div12 { grid-column-start: 2; grid-row-start: 13; }
        .div13 { grid-column-start: 2; grid-row-start: 14; }
        .div14 { grid-column-start: 2; grid-row-start: 15; }
        .div15 { grid-column-start: 2; grid-row-start: 16; }
        .div16 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 3; margin-left:80px }
        .div17 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 4; margin-left:80px}
        .div18 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 5; margin-left:80px}
        .div19 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 6; margin-left:80px}
        .div20 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 7; margin-left:80px}
        .div21 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 8; margin-left:80px}
        .div22 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 9; margin-left:80px}
        .div23 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 10; margin-left:80px}
        .div24 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 11; margin-left:80px}
        .div25 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 12; margin-left:80px}
        .div26 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 13; margin-left:80px}
        .div27 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 14; margin-left:80px}
        .div28 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 15; margin-left:80px}
        .div29 { grid-column: span 2 / span 2; grid-column-start: 3; grid-row-start: 16; margin-left:80px}
        
        /* Adding image and date styles */
        .div30 {
            grid-row: span 2 / span 2;
            grid-column-start: 5;
            grid-row-start: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .div30 img {
            max-width: 100%;
            height: auto;
            padding-top:20px;
        }

        .div31 {
            grid-column-start: 1;
            grid-row-start: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top:20px;
        }
        .print-button{
            margin: 0 5px;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #002d72;
            color: white;
            border: none;
            border-radius: 5px;
            font-size:12px;
            height:30px;
            width: 30%;
        }
        .print-button:hover {
            background-color: #0056a1; 
            transform: scale(1.05); 
        }
    </style>
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
       @media print {
            /* A4 portrait dimensions */
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            .parent {
                width: 210mm;
                height: 297mm;
            }

            /* Optional: A4 landscape example 
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            .parent {
                width: 297mm;
                height: 210mm;
            }
            */

            /* Hide elements not needed for print */
            .pagination, .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="parent">
        <div class="div2">Requst Number:</div>
        <div class="div3">Owner of Request(Staff):</div>
        <br>
        <div class="div4"><h3>Requestee Information</h3></div>
        
        <div class="div5">Requestee:</div>
        <div class="div6">Organization/Office:</div>
        <div class="div7">Phone number:</div>
        <div class="div8">Email Address:</div>
        <div class="div9">Address:</div>
        <br>
        <div class="div10"><h3>Donation Request Details</h3></div>
        
        <div class="div11">Type of requested forest product:</div>
        <div class="div12">Species:</div>
        <div class="div13">Quantity:</div>
        <div class="div14">Description:</div>
        <div class="div15">Purpose of donation:</div>
        <div class="div16"></div>
        <div class="div17"></div>
        <div class="div18"></div>
        <div class="div19"></div>
        <div class="div20"></div>
        <div class="div21"></div>
        <div class="div22"></div>
        <div class="div23"></div>
        <div class="div24"></div>
        <div class="div25"></div>
        <div class="div26"></div>
        <div class="div27"></div>
        <div class="div28"></div>
        <div class="div29"></div>
        
        <div class="div30">
            <img src="/Images/PENRO-LOGO.png" style="width:80px;" alt="PENRO Logo">
        </div>
        <div class="div31" id="currentDate"></div>
    </div>

    <script>
        $(document).ready(function() { 
            var currentDate = new Date().toLocaleDateString();
            $('#currentDate').text(currentDate);

            var id = "<?php echo $id; ?>";
            if(id){
                $.ajax({
                    url: '/Admin/Requests/Completed/get-record-by-id.php',
                    type: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            let record = data.data[0];
                            // $('.div16').text(record.request_number);
                            $('.div16').html('<strong>' + record.request_number + '</strong>'); 
                            $('.div17').html('<strong>' + record.created_by + '</strong>'); 
                            $('.div19').html('<strong>' + record.requestor_name + '</strong>'); 
                            $('.div20').html('<strong>' + record.organization_name + '</strong>'); 
                            $('.div21').html('<strong>' + record.phone_number  + '</strong>'); 
                            $('.div22').html('<strong>' + record.email  + '</strong>'); 
                            $('.div23').html('<strong>' + record.address  + '</strong>'); 

                            $('.div25').html('<strong>' + record.type_of_requested_item  + '</strong>'); 
                            $('.div26').html('<strong>' + record.name_of_requested_item  + '</strong>');
                            $('.div27').html('<strong>' + record.quantity  + '</strong>'); 
                            $('.div28').html('<strong>' + record.request_description +'</strong>'); 
                            // Display the purpose of donation in div29 with bold formatting and include the print button
                            $('.div29').html('<strong>' + record.purpose_of_donation + '</strong><br><br><br> ' +
                                '<button class="print-button" onclick="window.print()">' +
                                '<i class="fas fa-print"></i> Print' +
                            '</button>');
 
                        } else {
                            Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                    }
                });
            }
        });

    </script>
</body>
</html>
