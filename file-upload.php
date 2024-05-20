<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File Upload and JSON Display</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<!-- data table -->
<script src="Styles/data-table/jquery-3.7.1.js"></script>
<script src="Styles/data-table/dataTables.js"></script>
<link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" rel="stylesheet" />
<style>
    body{
        font-family: 'Poppins', sans-serif;
        font-size:12px;
    }
    table,td,th{
        border:1px solid black;
    }
    .container {
        display: flex;
        flex-direction: column;
       
    }
    .content {
        flex-grow: 1; /* Allows the content to grow to fill remaining space */
        background-color: lightblue;
        overflow-x:scroll;
    }
</style>
</head>
<body>

<h2>Upload Excel File</h2>
<input type="file" id="fileInput" accept=".xls,.xlsx">
<br><br>
<button onclick="handleFile()">Load Data</button>

<div class="container">
    <div class="content">
        <table id="dataTable" class="display" style="width:100%" >
        <thead>
        <tr>
            <th style="width:10%;">ID</th>
            <th>Car</th>
            <th>Truck</th>
            <th>Jeepney</th>
        </tr>
        </thead>
        <tbody id="dataBody">
        </tbody>

        <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Car</th>
                    <th>Truck</th>
                    <th>Jeepney</th>
                </tr>
        </tfoot>
        </table>
    </div>
</div>



<script>
  let tableData = [];
  let currentPage = 1;
  const pageSize = 5;

  new DataTable('#dataTable', {
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.footer().textContent;
 
                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);
 
                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
        }
    });

  

  function handleFile() {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];
    
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        const data = new Uint8Array(event.target.result);
        const workbook = XLSX.read(data, {type: 'array'});
        const sheetName = workbook.SheetNames[0];
        const sheet = workbook.Sheets[sheetName];
        const jsonData = XLSX.utils.sheet_to_json(sheet, {header: 1});
        
        displayJSON(jsonData); // Remove the header row
      };
      reader.onerror = function(event) {
        console.error("File could not be read! Code " + event.target.error.code);
      };
      reader.readAsArrayBuffer(file);
    } else {
      alert('Please select a file.');
    }
  }
  
  function displayJSON(data) {
    const headers = ['Car', 'Truck', 'Jeepney']; // Hardcoded headers
    const jsonData = [];
    data.forEach(row => {
        const obj = {};
        headers.forEach((header, index) => {
            obj[header] = row[index] || ''; // Ensure that missing values are handled gracefully
        });
        jsonData.push(obj);
    });
    const jsonString = JSON.stringify(jsonData, null, 2);
    // alert(jsonString);
    sendData(jsonData);
}

function sendData(data) {
    const jsonData = JSON.stringify(data);
    $.ajax({
        url: '/file-upload-insert-data.php',
        type: 'POST',
        contentType: 'application/json',
        data: jsonData,
        success: function(response) {
            console.log('Success:', response);
            fetchDataFromDB();
            alert("Data inserted successfully.");
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert("Error inserting data. See console for details.");
        }
    });
}

function fetchDataFromDB() {
    $.ajax({
        url: '/file-upload-get-data.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Success:', response);
            // Handle the response data here, e.g., update your HTML table
            updateTable(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            // Handle error gracefully, e.g., show an error message to the user
            alert("Error fetching data from the server. See console for details.");
        }
    });
}

function updateTable(data) {
    const table = $('#dataTable').DataTable();
    
    // Clear the existing data from the DataTable
    table.clear();
    
    // Add new data
    data.forEach(rowData => {
        // Create an array to hold cell values for this row
        const rowDataArray = [];
        
        // Loop through each value in the rowData object and push it into the array
        Object.values(rowData).forEach(value => {
            rowDataArray.push(value);
        });
        
        // Add the row to the DataTable
        table.row.add(rowDataArray);
    });
    
    // Redraw the DataTable
    table.draw();
}

// Call fetchDataFromDB() when the page loads
$(document).ready(function() {
    fetchDataFromDB();
});




</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
</body>
</html>
