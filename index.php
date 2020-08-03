<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>DataGrid</title>
        <style>
            .example {
                padding-left: 25px;
                padding-right: 25px;
                border: 1px dotted gray;
                padding-top: 25px;
                border-radius: 5px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="example">
                <?php
                    include 'State.php';
                    include 'DataType.php';
                    include 'DataGrid.php';
                    include 'Config.php';
                    include 'Column.php';
                    include 'Test.php';

                    $rows = json_decode(file_get_contents("DataSet.json"), true);

                    $state = HttpState::create(); // instanceof State, data should be fetched from $ _GET (NOT SURE HOW TO USE WITHOUT FIRST CREATING AN OBJECT)

                    $dataGrid = new HtmlDataGrid(); // instanceof DataGrid

                    $config = (new DefaultConfig) // instanceof Config, with additional methods
                        ->addIntColumn('id')
                        ->addTextColumn('name')
                        ->addIntColumn('age')
                        ->addTextColumn('company')
                        ->addCurrencyColumn('balance', 'USD')
                        ->addTextColumn('phone')
                        ->addTextColumn('email');
                    
                    echo $dataGrid->withConfig($config)->render($rows, $state);

                ?>
                
            </div>
        </div>
    </body>
</html>
