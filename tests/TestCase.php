<?php
namespace Tests;

use App\Model\Plan;
use App\Model\User;
use Illuminate\Contracts\Console\Kernel;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param array $arguments
     *
     * @return User
     */
    protected function createTestUser($arguments = [])
    {
        !isset($arguments['plan_id']) && $arguments['plan_id'] = $this->createTestPlan()->id;

        $user = factory(User::class)->create($arguments);

        return $user;
    }

    /**
     * @return Plan
     */
    protected function createTestPlan()
    {
        $plan = factory(Plan::class)->create();

        return $plan;
    }
}
