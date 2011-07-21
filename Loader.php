<?php

require_once (dirname(__FILE__) . '/Classes/ReadyAskableInterface.php');
require_once (dirname(__FILE__) . '/Classes/JoinPoint.php');
require_once (dirname(__FILE__) . '/Classes/ThreadFactory.php');

require_once (dirname(__FILE__) . '/Classes/Communication/CommunicationInterface.php');
require_once (dirname(__FILE__) . '/Classes/Communication/SharedMemory.php');

require_once (dirname(__FILE__) . '/Classes/Thread/ThreadInterface.php');
require_once (dirname(__FILE__) . '/Classes/Thread/ReturnableThreadInterface.php');
require_once (dirname(__FILE__) . '/Classes/Thread/AbstractThread.php');
require_once (dirname(__FILE__) . '/Classes/Thread/PHPThread.php');
require_once (dirname(__FILE__) . '/Classes/Thread/PHPReturnableThread.php');

require_once (dirname(__FILE__) . '/Classes/Pool.php');
