<?php
/*
 * @Date         : 2022-03-02 14:49:25
 * @LastEditors  : Jack Zhou <jack@ks-it.co>
 * @LastEditTime : 2022-03-02 17:22:16
 * @Description  : 
 * @FilePath     : /recruitment-php-code-test/tests/App/DemoTest.php
 */

namespace Test\App;

use PHPUnit\Framework\TestCase;
use App\App\Demo;
use App\Service\AppLogger;
use App\Util\HttpRequest;

class DemoTest extends TestCase {

    public function test_get_user_info() {
        $obj = new Demo(new AppLogger(), new HttpRequest());

        $userInfo = $obj->get_user_info();

        $this->assertArrayHasKey('id', $userInfo);
        $this->assertArrayHasKey('username', $userInfo);
    }
}