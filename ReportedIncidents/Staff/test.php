<script>

let tableData = [];
            let currentPage = 1;
            const pageSize = 5;

            new DataTable('#incidentReportDataTable', {
                initComplete: function () {
                    const api = this.api();
                    // Hide columns in a single operation
                    api.columns([
                        6, //date_assigned
                        7,//date_reported
                        8, //reported_by
                        9, //created_by
                        10, //updated_by
                        11, //activity_date
                        12, //created_on
                        13, //location
                        14, //coordinate_lat
                        15, //coordinate_lng
                        16 //illegal_activity_detail
                    ]).visible(false);

                    api.columns().every(function (index) { 
                        const column = this;
                        const footer = column.footer();
                        //disabling the footer search for action
                        if (index !== 16) { 
                            const input = document.createElement('input'); 
                            input.placeholder = column.footer().textContent;
                            if (footer) { 
                                footer.innerHTML = ''; 
                                footer.appendChild(input);

                                // Event listener for user input
                                input.addEventListener('keyup', debounce(() => {
                                    if (column.search() !== input.value) {
                                        column.search(input.value).draw();
                                    }
                                }, 300)); 
                            }
                        }
                    });
                }
            });

            // Debounce function to limit the rate at which the search is performed
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }      
            
            function fetchDataFromDB() {
                $.ajax({
                    url: '/ReportedIncidents/Staff/GET/get-record.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // console.log('Success:', response);
                        updateTable(response);//call updateTable
                    },
                    error: function(xhr, status, error) {
                        // console.error('Error:', error);
                        // console.log(xhr.messageText);
                        // console.log(xhr);
                    }
                });
            }

            function updateTable(data) {
                const table = $('#incidentReportDataTable').DataTable();
                table.clear(); // Clear the existing data from the DataTable

                data.forEach(rowData => {
                    const rowDataArray = [];

                    // Iterate over the object values to push each value to rowDataArray
                    Object.values(rowData).forEach(value => {
                        rowDataArray.push(value);
                    });

                    // Log the row data before appending action buttons
                    console.log("Row data before adding action buttons:", rowDataArray);

                    // Add action buttons as the last column
                    rowDataArray.push(`
                        <div class="dropdown">
                            <button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item edit-action" href="#" data-id="${rowData['id']}"> Edit <i class="bi bi-pencil-fill" style="float:right"></i></a></li>
                                <li><a class="dropdown-item delete-action" href="#" data-id="${rowData['id']}"> Delete <i class="bi bi-trash-fill" style="float:right"></i></a></li>
                            </ul>
                        </div>
                    `);

                    // Log the final row with the action buttons
                    console.log("Final row data with action buttons:", rowDataArray);

                    // Add the row to the DataTable
                    table.row.add(rowDataArray);
                });

                table.order([12, 'desc']).draw(); // Redraw the DataTable
            }
</script>