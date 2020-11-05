<?php

namespace WorkRobot;

/**
 * Interface RobotInterface
 */
interface RobotInterface {

    public function sendRecordByRobot();
    public function getTypeContent($class_name, $replace_arr, $closureData);
    public function setMarkdown($mstype);

}