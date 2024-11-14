<!DOCTYPE html>
<html>
<head>
    <title>Embedded QR Code</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

<div id="qrcode"></div>

<script>
const qrcode = new QRCode(document.getElementById('qrcode'), {
  text: 'https://samplelinkforDetails.com/1',
  width: 128,
  height: 128,
  colorDark : '#000',
  colorLight : '#fff',
  correctLevel : QRCode.CorrectLevel.H
});
</script>
</body>
</html>
