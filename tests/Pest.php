<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a mock DerivClient that returns the expected response
 * 
 * @param array $expectedResponse The response that the mock client should return
 * @return \Mockery\MockInterface
 */
function createMockClient($expectedResponse)
{
    $mockClient = Mockery::mock(\Rndwiga\DerivApis\Client\DerivClient::class);
    $mockClient->shouldReceive('sendRequest')
        ->andReturn($expectedResponse);
    return $mockClient;
}

/**
 * Create a simple mock DerivClient that always returns the expected response
 * regardless of the request parameters
 * 
 * @param array $expectedResponse The response that the mock client should return
 * @return \Mockery\MockInterface
 */
function createSimpleMockClient($expectedResponse)
{
    $mockClient = Mockery::mock(\Rndwiga\DerivApis\Client\DerivClient::class);
    $mockClient->shouldReceive('sendRequest')
        ->withAnyArgs()
        ->andReturn($expectedResponse);
    return $mockClient;
}
