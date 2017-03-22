<?php
/**
 * @category    BastaYa
 * @package     BastaYa_Log
 * @copyright   Copyright (c) 2017 Bartek Nowaczyk (http://www.barteknowaczyk.com)
 * @license     MIT
 * @author      Bartek Nowaczyk <bart.nowaczyk@gmail.com>
 */

interface BastaYa_Log_Model_Channels_IChannels
{
    public function configure(Array $params);

    public function send($identifier, $logType, $message);
}