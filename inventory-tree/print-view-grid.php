<?php ?>
<!DOCTYPE html>
<html>
<head>
<title>Print View</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>

body{
    padding:20px;
    font-family: 'Poppins', sans-serif;
}
.parent {
    display: grid;
    grid-template-columns: repeat(18, 1fr); /* Change to 18 columns */
    grid-template-rows: repeat(8, 1fr);
    gap: 2px;
    font-size:10px;
    background-color: black;
    padding:2px;
}
    
.div1 {
    grid-row: span 2 / span 2;
    background-color: #002f6c;
    color:white;
}

.div2 {
    grid-row: span 2 / span 2;
    grid-column:span 2 / span 2;
    background-color: #002f6c;
    color:white;
}

/* .div3 {
    grid-row: span 2 / span 2;
    background-color: #a1a1a1;
} */

.div4 {
    grid-row: span 2 / span 2;
    background-color: #002f6c;
    color:white;
}

.div5 {
    grid-row: span 2 / span 2;
    background-color: #002f6c;
    color:white;
}

.div6 {
    grid-column: span 7 / span 7; /* spans 7 columns */
    background-color: #002f6c;
    color:white;
}

/* New divs placed after div6 */
.div14 {
    grid-column-start: 13;
    grid-row: span 1 / span 1;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div15 {
    grid-column-start: 14;
    grid-row: span 1 / span 1;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div16 {
    grid-column-start: 15;
    grid-row: span 1 / span 1;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div17 {
    grid-column-start: 16;
    grid-row: span 1 / span 1;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div18 {
    grid-column-start: 17;
    grid-row: span 2 / span 2;
    grid-row-start: 1;
    background-color: #002f6c;
    color:white;
}

.div19 {
    grid-column-start: 18;
    grid-row-start: 1;
    grid-row: span 2 / span 2;
    background-color: #002f6c;
    color:white;
}

.div20 {
    grid-column: span 4 / span 4; /* spans 7 columns */
    background-color: #002f6c;
    color:white;
    grid-row-start: 1;
    grid-column-start: 13;
}

.div7 {
    grid-column-start: 6;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div8 {
    grid-column-start: 7;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div9 {
    grid-column-start: 8;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div10 {
    grid-column-start: 9;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div11 {
    grid-column-start: 10;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div12 {
    grid-column-start: 11;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}

.div13 {
    grid-column-start: 12;
    grid-row-start: 2;
    background-color: #002f6c;
    color:white;
}
/* Row data */
.div21{
    grid-column-start: 1;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div22{
    grid-column-start: 2;
    grid-row-start: 3;
    background-color: #f1f1f1;
    grid-column: span 2 / span 2;
}
.div23{
    grid-column-start: 4;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div24{
    grid-column-start: 5;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div25{
    grid-column-start: 6;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div26{
    grid-column-start: 7;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div27{
    grid-column-start: 8;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div28{
    grid-column-start: 9;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div29{
    grid-column-start: 10;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div30{
    grid-column-start: 11;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div31{
    grid-column-start: 12;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div32{
    grid-column-start: 13;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div33{
    grid-column-start: 14;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div34{
    grid-column-start: 15;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div35{
    grid-column-start: 16;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div36{
    grid-column-start: 17;
    grid-row-start: 3;
    background-color: #f1f1f1;
}
.div37{
    grid-column-start: 18;
    grid-row-start: 3;
    background-color: #f1f1f1;
}


</style>
</head>
<body>
<!-- <b><p></p></b> -->
<div class="parent">
    <div class="div1"><b><p>ID</p></b></div>
    <div class="div2"><b><p>Name of Respondent/Claimant/Owner</p></b></div>
    <!-- <div class="div3"><b><p>3.</p></b></div> -->
    <div class="div4"><b><p>Date of Apprehension</p></b></div>
    <div class="div5"><b><p>Apprehending Officer</p></b></div>
    <div class="div6"><b><p>Forest Product Description</p></b></div>
    
    <!-- New divs placed after div6 -->
    <div class="div14"><b><p>Vehicle/Brand</p></b></div>
    <div class="div15"><b><p>Type of vehicle</p></b></div>
    <div class="div16"><b><p>Plate #</p></b></div>
    <div class="div17"><b><p>Conveyance Estimated Val. (P)</p></b></div>

    <div class="div18"><b><p>Administrative status</p></b></div>
    <div class="div19"><b><p>Remarks</p></b></div>

    <div class="div20"><b><p>Conveyance</p></b></div>
    
    <div class="div7"><b><p>Quantity (pcs)</p></b></div>
    <div class="div8"><b><p>Volume bd. ft.</p></b></div>
    <div class="div9"><b><p>Linear mtrs</p></b></div>
    <div class="div10"><b><p>Estimated Value (P)</p></b></div>
    <div class="div11"><b><p>Type/Kind (Species)</p></b></div>
    <div class="div12"><b><p>Place of Depository</p></b></div>
    <div class="div13"><b><p>Place of Apprehension</p></b></div>

    <!-- row data -->
    <div class="div21"><b><p>125</p></b></div>
    <div class="div22"><b><p>Joseph Abraham, Jessica Gojo</p></b></div>
    <div class="div23"><b><p>2024-10-26</p></b></div>
    <div class="div24"><b><p>CENRO</p></b></div>
    <div class="div25"><b><p>2412</p></b></div>
    <div class="div26"><b><p>160 bd</p></b></div>
    <div class="div27"><b><p>130</p></b></div>
    <div class="div28"><b><p>103,820.00</p></b></div>
    <div class="div29"><b><p>Acacia</p></b></div>
    <div class="div30"><b><p>Lalakay, Los Banos Laguna</p></b></div>
    <div class="div31"><b><p>Sitio Makulot Halang, Calamba Laguna</p></b></div>
    <div class="div32"><b><p>Toyota</p></b></div>
    <div class="div33"><b><p>Closed Van</p></b></div>
    <div class="div34"><b><p>WLM-775</p></b></div>
    <div class="div35"><b><p>Php. 200,000.00</p></b></div>
    <div class="div36"><b><p>Final Report submitted to R.O dated 06/25/2020</p></b></div>
    <div class="div37"><b><p>Sample record</p></b></div>
    
</div>

<button class="print-button" onclick="printDiv()">Print</button>

<script>
    function printDiv() {
        var printContents = document.querySelector('.parent').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to restore the original contents
    }
</script>
</body>
</html>
