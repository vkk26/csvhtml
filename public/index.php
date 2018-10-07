

<html>
<head>
    <title>CSV file to HTML table </title>
    <link rel="stylesheet" type="text/css" href="styling.css">
   </head>
<body>
<?php
main::start("example.csv");
class main  {
    static public function start($filename) {
        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
    }
}
class html {
    public static function generateTable($records) {
        echo "<table width=''>" ;
        
        $count = 1;
        echo "<tr>";
        foreach ($records[0] as $tableHeadings => $values) {
            echo "<th>$tableHeadings</th>";
        }
        echo "</tr>";
        foreach ($records as $arrays){
            if($count > 0) {
                echo "<tr>";
                foreach ($arrays as $tableRows => $values) {
                    echo "<td>$values</td>";
                }
                echo "</tr>";
            }
            $count++;
        }
        echo "</table>";
    }
}
class csv {
    static public function getRecords($filename) {
        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;
        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}
class record {
    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function returnArray() {
        $array = (array) $this;
        return $array;
    }
    public function createProperty($name, $value) {
        $this->{$name} = $value;
    }
}
class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
    }
}


?>
</body>
</html>


