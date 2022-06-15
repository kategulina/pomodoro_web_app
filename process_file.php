<?php
    /**
     * Function for saving text in db directory
     * 
     * @param user name of json file where data will be saved 
     * @param data to save 
     */
    function saveTo($user, $data) {
        // save data to user.json
        file_put_contents("db/".$user.".json", $data);        
    }

    /**
     * Function for getting data from file in db directory
     * 
     * @param user name of json file, where data is 
     * @return string data from file
     */
    function getTextFromFile($user) {
        $path = "db/".$user.".json";

        if (!file_exists($path)) {
            createFile($path);
        }
        return file_get_contents($path);
    }

    /**
     * Function for creating file in db directory
     * Creates empty file
     * 
     * @param path to file
     */
    function createFile($path) {
        file_put_contents($path, "");     
    }
?>