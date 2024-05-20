<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Refresh Demo</title>
</head>
<body>
    <div id="refreshDiv">
        <!-- Content to be refreshed goes here -->
        
    </div>

    <script>
        window.onload = function() {
            // Function to refresh the content of the div
            function refreshDiv() {
                // Create a new XMLHttpRequest object
                var xhttp = new XMLHttpRequest();

                // Define what happens on successful data submission
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Update the content of the div with the response
                        document.getElementById("refreshDiv").innerHTML = this.responseText;
                    }
                };

                // Send a request to the server to fetch the data
                xhttp.open("GET", "fetch-data.php", true);
                xhttp.send();
            }

            // Interval for refreshing the div (milliseconds)
            var refreshInterval = 100; 

            // Initial call to refresh the div
            refreshDiv();

            // Setting up the interval to periodically refresh the div
            var intervalId = setInterval(refreshDiv, refreshInterval);

            // Prevent refreshing when highlighting text
            var isHighlighting = false;
            document.body.addEventListener('mousemove', function(event) {
                var selection = window.getSelection();
                if (selection && selection.toString().length > 0) {
                    isHighlighting = true;
                    clearInterval(intervalId);
                } else {
                    if (isHighlighting) {
                        isHighlighting = false;
                        setTimeout(function() {
                            intervalId = setInterval(refreshDiv, refreshInterval);
                        }, 100);
                    }
                }
            });
        };
    </script>
</body>
</html>
