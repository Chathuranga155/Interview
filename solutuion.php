<?php

// Input data
$budget = 400;

$products = [
    ["name" => "Product A", "cost" => 10, "target_stock" => 50, "current_stock" => 20],
    ["name" => "Product B", "cost" => 20, "target_stock" => 30, "current_stock" => 15],
    ["name" => "Product C", "cost" => 15, "target_stock" => 40, "current_stock" => 10],
];


//calculate product need to be restocked to reach the target stock.

foreach ($products as &$product) {
    $product['needed'] = $product['target_stock'] - $product['current_stock'];
}
unset($product); 


usort($products, function ($a, $b) {
    return $a['current_stock'] - $b['current_stock'];
});


$total_cost = 0;

foreach ($products as &$product) {
   
    $affordable_units = min($product['needed'], floor(($budget - $total_cost) / $product['cost']));
    $product['restocked'] = $affordable_units;
    
    // Update the total cost
    $total_cost += $affordable_units * $product['cost'];
}
unset($product); 

// Calculate the remaining budget
$remaining_budget = $budget - $total_cost;

// Output 
echo "Restocking Summary:\n";

foreach ($products as $product) {
    echo "{$product['name']}: Restocked {$product['restocked']} units\n";
}

echo "Total cost: \$$total_cost\n";
echo "Remaining budget: \$$remaining_budget\n";

?>
