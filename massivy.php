<?php

    $data = [
        ['Иванов', 'Математика', 5],
        ['Иванов', 'Математика', 4],
        ['Иванов', 'Математика', 5],
        ['Петров', 'Математика', 5], // there was a mistake here, you forgot the quote marks '' for Петров
        ['Сидоров', 'Физика', 4],
        ['Иванов', 'Физика', 4],
        ['Петров', 'ОБЖ', 4],
    ];

    $marks_sum = [];

    // making multimensionnal array :
    // 1st level : student name
    // 2st level : another array => ['discipline1' => sum of marks, 'discipline2' => sum of marks, ...]
    foreach ($data as $row) {
        $name = null;
        $discipline = null;
        $mark = null;

        foreach ($row as $key => $value) {
            // if it's the student name column
            if ($key == 0) {
                $name = $value;
            }
            // if it's the discipline column
            elseif ($key == 1) {
                $discipline = $value;
            }
            // if it's the mark column
            elseif ($key == 2) {
                $mark = $value;
            }
        }

        $marks_sum[$name][$discipline] += $mark;
    }

    // ordering first level of the multidimensionnal array by student name
    ksort($marks_sum, SORT_STRING);

    // we assume we have only those disciplines available
    $disciplines0 = ['Математика', 'ОБЖ', 'Физика'];

    // adding disciplines without marks to the array to ease writing html table rows
    foreach ($marks_sum as $student => $student_data) {
        // storing student disciplines with marks
        $disciplines1 = [];
        foreach ($student_data as $discipline1 => $sum_marks) {
            $disciplines1[] = $discipline1;
        }

        // adding student disciplines with no marks if needed
        foreach ($disciplines0 as $discipline0) {
            if (!in_array($discipline0, $disciplines1)) {
                $marks_sum[$student][$discipline0] = null;
            }
        } 
    }

    // ordering second level of the multidimensionnal array by discipline name
    foreach ($marks_sum as $student => $student_data) {
        ksort($marks_sum[$student], SORT_STRING);
    }

    $html_table_rows = '';

    // generating html for the rows of the table
    foreach ($marks_sum as $student => $student_data) {
        $html_table_rows .= '<tr><td>'.$student.'</td>';

        foreach ($student_data as $discipline => $sum_marks) {
            $html_table_rows .= '<td>'.$sum_marks.'</td>';
        }

        $html_table_rows .= '</tr>';
    }

?>

<html>

    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>

    <body>
        <a href="index.php">Home</a>
        
        <h1>Массивы</h1>

        <table>
            <tr>
                <td></td>
                <td>Математика</td>
                <td>ОБЖ</td>
                <td>Физика</td>
            </tr>
            <?= $html_table_rows ?>
        </table>
    </body>

</html>