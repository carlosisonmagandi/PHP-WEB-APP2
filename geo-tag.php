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

        #coords, #completeAddress {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Upload Geo Tag Image</h2>
    <input type="file" id="imageInput" accept="image/*" required/>
    
    <div id="loader"></div>

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
                            // console.log(text);
                            // Extract coordinates and full address from the recognized text
                            extractCoordinatesAndAddress(text);

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

        function extractCoordinatesAndAddress(text) {
            // Extract coordinates using regex
            var coordinateRegex = /Lat\s*([+-]?\d+\.\d+)\s*Long\s*([+-]?\d+\.\d+)/;
            var match = text.match(coordinateRegex);

            var latitude = '';
            var longitude = '';
            var address = '';

            if (match) {
                latitude = match[1];
                longitude = match[2];

                // Display coordinates
                document.getElementById("coords").innerHTML = `Latitude: ${latitude}, Longitude: ${longitude}`;
                
                // Post the coordinates to the parent window
                window.parent.postMessage({
                    latitude: latitude,
                    longitude: longitude,
                    address: address
                }, "*");
            } else {
                document.getElementById("coords").innerText = "No GPS coordinates found in the text overlay.";
            }

            // Now let's extract the full address, assuming it's included in the image text
            address = text.replace(/.*Lat.*Long.*/g, '').trim();

            // Clean up the extracted address to remove unwanted artifacts and the timestamp
            address = address.replace(/[|]/g, ''); // Remove any vertical bars
            address = address.replace(/V'\s*/g, ''); // Remove 'V' followed by any spaces
            address = address.replace(/AH\s*/g, ''); // Remove 'AH' followed by any spaces
            
            // Remove the timestamp-like pattern (e.g., "REEN 2024/11/13 12:43")
            address = address.replace(/REEN\s*\d{4}\/\d{2}\/\d{2}\s*\d{2}:\d{2}/g, '').trim();

            // Check if the address has content
            if (address) {
                document.getElementById("completeAddress").innerText = `${address}`;
                
                // Include the cleaned address in the postMessage as well
                window.parent.postMessage({
                    latitude: latitude,
                    longitude: longitude,
                    address: address
                }, "*");
            } else {
                document.getElementById("completeAddress").innerText = "No address found in the image text.";
            }
        }



    </script>
</body>
</html>
