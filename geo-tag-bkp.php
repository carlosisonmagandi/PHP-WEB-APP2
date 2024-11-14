<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style>
       
        #loader {
            display: none;
            border: 16px solid #f3f3f3; 
            border-top: 16px solid #3498db; 
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        #coords {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Upload Geo Tag Image</h2>
    <input type="file" id="imageInput" accept="image/*" required/>
    
    <div id="loader"></div>

    <!-- Coordinates display area -->
    <!-- <p id="coords">Coordinates will appear here...</p> -->
    <p id="coords"></p>
    <p id="completeAddress"></p>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.1/dist/tesseract.min.js"></script>
    <script>
        document.getElementById("imageInput").addEventListener("change", function(event) {
            var file = event.target.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = new Image();
                    img.onload = function() {
                       
                        document.getElementById("loader").style.display = 'block';

                        // Use Tesseract.js to extract text from the image
                        Tesseract.recognize(
                            img,
                            'eng', 
                            {
                                logger: function(m) {
                                    // console.log(m);
                                }
                            }
                        ).then(({ data: { text } }) => {
                            // console.log("Extracted Text: ", text);
                            extractCoordinates(text);

                            document.getElementById("loader").style.display = 'none';
                        }).catch((error) => {
                            console.error("Error processing image:", error);

                            document.getElementById("loader").style.display = 'none';
                            document.getElementById("coords").innerText = "Error extracting text. Please try again.";
                        });
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function extractCoordinates(text) {
            var coordinateRegex = /Lat\s*([+-]?\d+\.\d+)\s*Long\s*([+-]?\d+\.\d+)/;
            var match = text.match(coordinateRegex);

            if (match) {
                var latitude = match[1];
                var longitude = match[2];

                document.getElementById("coords").innerHTML = `Latitude: ${latitude}, Longitude: ${longitude}`;
                window.parent.postMessage({ latitude: latitude, longitude: longitude }, "*");
            } else {
                document.getElementById("coords").innerText = "No GPS coordinates found in the text overlay.";
            }
        }
    </script>
</body>
</html>
