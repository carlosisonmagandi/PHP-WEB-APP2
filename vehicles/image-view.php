<!DOCTYPE html>
<html lang="en">
<head>
  <title>Image View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Added Font Awesome -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>
    html, body {
      height: 100%; 
      background: #ffffff; 
      background: -webkit-linear-gradient(0deg, #000000 0%, #ffffff 100%);
      background: linear-gradient(0deg, #000000 0%, #ffffff 100%);
      color:#f1f1f1;
      margin: 0;
    }

    .container {
      display: flex;
      flex-direction: column;
      justify-content: center; 
      align-items: center;
      height: 100vh;
    }

    .centered-div {
      width: 90%; 
      max-width: 600px; 
      height: auto; 
      background-color: rgba(30, 30, 30, 0.8); 
      border: 1px solid rgba(255, 255, 255, 0.2); 
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center; 
      border-radius: 8px; 
      display: flex; 
      flex-direction: column;
      justify-content: center;
      align-items: center; 
      padding: 20px; 
    }

    .centered-div img {
      width: 100%; 
      height: auto; 
      max-height: 100%;
      border-radius: 8px; 
    }

    .text-below {
      margin-top: 20px;
      color: #f1f1f1; /* Light text color */
    }

    .download-btn {
      margin-top: 10px; 
      color: #f1f1f1;
      text-decoration: none;
      font-size: 24px; /* Font size for the icon */
    }
  </style>
</head>
<body>

<div class="container">
  <div class="centered-div">
    <img class="embed-responsive-item" src="" alt="Image will be loaded here" id="imageElement" />
    <a href="#" id="downloadLink" class="download-btn" download>
      <i class="fas fa-download"></i>
    </a>
  </div>
  
  <i><p class="text-below">Press CTRL + W key to close...</p></i>
</div>

<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var image_id = urlParams.get('id'); 
        
        if (image_id) {
            $.ajax({
                url: '/vehicles/image-view-get.php', 
                type: 'GET',
                data: { image_id: image_id },
                dataType: 'json',
                success: function(response) {
                    var originalPath = response.data.file_path;
                    var modifiedPath = originalPath.replace('inventory-tree/', '');

                    // Set image source
                    $('#imageElement').attr('src', modifiedPath);

                    // Set download link
                    $('#downloadLink').attr('href', modifiedPath);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('An error occurred while fetching the image path.');
                }
            });
        } else {
            alert('Image ID not found in the URL.');
        }
    });
</script>

</body>
</html>
