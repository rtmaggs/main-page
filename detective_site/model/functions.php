<?php
    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }

    function grabColumns() 
    {
        $columns = array
        (
            'case_id', 'case_title', 'case_description'
        );

        return($columns);
    }
?>
