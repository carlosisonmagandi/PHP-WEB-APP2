<?php
require_once("../../includes/db_connection.php");

$categories_sql = "SELECT species_type AS category FROM inventory
    UNION
    SELECT category_type FROM equipments
    UNION
    SELECT category_type FROM vehicles
";
$categories_result = $connection->query($categories_sql);

$categories = array();
if ($categories_result->num_rows > 0) {
    while($row = $categories_result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}

// Fetching data for each category and month counts
$data = array();
$current_year = date('Y');

foreach ($categories as $category) {
    // Inventory counts by month
    $inventory_sql = "SELECT 
            YEAR(date_of_apprehension) AS apprehension_year,
            MONTH(date_of_apprehension) AS apprehension_month,
            COUNT(*) AS apprehension_count
        FROM inventory
        WHERE species_type = '{$category}' AND YEAR(date_of_apprehension) = $current_year
        GROUP BY apprehension_year, apprehension_month
    ";

    $equipments_sql = "SELECT 
            YEAR(date_of_compiscation) AS apprehension_year,
            MONTH(date_of_compiscation) AS apprehension_month,
            COUNT(*) AS apprehension_count
        FROM equipments
        WHERE category_type = '{$category}' AND YEAR(date_of_compiscation) = $current_year
        GROUP BY apprehension_year, apprehension_month
    ";

    $vehicles_sql = "SELECT 
            YEAR(date_of_compiscation) AS apprehension_year,
            MONTH(date_of_compiscation) AS apprehension_month,
            COUNT(*) AS apprehension_count
        FROM vehicles
        WHERE category_type = '{$category}' AND YEAR(date_of_compiscation) = $current_year
        GROUP BY apprehension_year, apprehension_month
    ";

    $results = [
        'inventory' => $connection->query($inventory_sql),
        'equipments' => $connection->query($equipments_sql),
        'vehicles' => $connection->query($vehicles_sql)
    ];

    $category_data = array_fill(1, 12, 0); // Initialize counts for each month (1 to 12)

    // Process inventory result
    if ($results['inventory']->num_rows > 0) {
        while ($row = $results['inventory']->fetch_assoc()) {
            $month = (int)$row['apprehension_month'];
            $category_data[$month] += (int)$row['apprehension_count'];
        }
    }

    // Process equipments result
    if ($results['equipments']->num_rows > 0) {
        while ($row = $results['equipments']->fetch_assoc()) {
            $month = (int)$row['apprehension_month'];
            $category_data[$month] += (int)$row['apprehension_count'];
        }
    }

    // Process vehicles result
    if ($results['vehicles']->num_rows > 0) {
        while ($row = $results['vehicles']->fetch_assoc()) {
            $month = (int)$row['apprehension_month'];
            $category_data[$month] += (int)$row['apprehension_count'];
        }
    }

    // Add data for this category
    $data[] = [
        'label' => $category,
        'data' => array_values($category_data)
    ];
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
