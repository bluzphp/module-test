<?php
/**
 * Example of initialization
 *
 * @author Anton Shevchuk
 */

namespace Application;

use Bluz\EventManager\Event;
use Bluz\Proxy\EventManager;
use Bluz\Proxy\Logger;

return function() {
    EventManager::attach('testspace:initevent', function(Event $event) {
        Logger::info('catch event');
        Logger::info('event '. $event->getName());
    });
};
