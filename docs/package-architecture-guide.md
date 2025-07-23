# Package Architecture Guide

This guide explains the architecture and design patterns used in the Deriv WebSocket API SDK. It's intended for developers who want to create a similar package for other APIs or services.

## Overview

The Deriv WebSocket API SDK is a PHP package that provides a clean, object-oriented interface for interacting with Deriv's WebSocket APIs. The package follows several design patterns and architectural principles to ensure maintainability, extensibility, and ease of use.

## Directory Structure

```
deriv_apis/
├── docs/                  # Documentation files
├── examples/              # Example usage scripts
├── src/                   # Source code
│   ├── Api/               # API handler classes
│   │   ├── Account.php    # Account API handler
│   │   ├── ApiInterface.php # Interface for all API handlers
│   │   ├── BaseApi.php    # Base class for all API handlers
│   │   ├── Trading.php    # Trading API handler
│   │   └── ...            # Other API handlers
│   ├── Client/            # Client implementation
│   │   └── DerivClient.php # WebSocket client
│   └── DerivAPI.php       # Main entry point
├── tests/                 # Test files
│   ├── Api/               # Tests for API handlers
│   └── ...                # Other tests
├── composer.json          # Composer configuration
└── README.md              # Main documentation
```

## Architecture

The package follows a layered architecture:

1. **Entry Point Layer** (`DerivAPI.php`): Provides a clean, fluent interface for accessing different API domains.
2. **API Handler Layer** (`Api/*.php`): Implements domain-specific API operations.
3. **Client Layer** (`Client/DerivClient.php`): Handles WebSocket communication.

### Entry Point Layer

The `DerivAPI` class serves as the main entry point and facade for all API operations. It:

- Manages the lifecycle of the WebSocket connection
- Provides methods to access different API domains (Account, Trading, etc.)
- Implements lazy loading for API handlers (only instantiating them when needed)

### API Handler Layer

Each API domain has its own handler class that extends `BaseApi` and implements `ApiInterface`. These handlers:

- Provide methods for specific API operations
- Format request parameters according to the API requirements
- Process API responses

### Client Layer

The `DerivClient` class handles the WebSocket communication with the API. It:

- Manages the connection lifecycle (connect, send, receive, disconnect)
- Handles authentication
- Formats requests as JSON and parses responses from JSON
- Implements error handling for connection issues

## Design Patterns

The package uses several design patterns:

### Facade Pattern

The `DerivAPI` class serves as a facade, providing a simplified interface to the complex subsystem of API handlers and WebSocket communication.

```php
// Without facade
$client = new DerivClient($appId);
$trading = new Trading($client);
$response = $trading->getPayoutCurrencies();

// With facade
$api = new DerivAPI($appId);
$response = $api->trading()->getPayoutCurrencies();
```

### Dependency Injection

API handlers depend on the `DerivClient`, which is injected through their constructors. This makes the code more testable and flexible.

```php
// DerivClient is injected into the Trading handler
$trading = new Trading($client);
```

### Factory Method Pattern

The `DerivAPI` class uses factory methods to create API handlers on demand.

```php
public function trading()
{
    if (!$this->trading) {
        $this->trading = new Trading($this->client);
    }

    return $this->trading;
}
```

### Adapter Pattern

The `DerivClient` class adapts the `WebSocket\Client` to the specific needs of the Deriv API.

### Command Pattern

Each API request is essentially a command object (array) sent to the server.

```php
$params = ['sell' => $contractId];
return $this->sendRequest($params);
```

### Template Method Pattern

The `BaseApi` class defines the common structure (sendRequest) and subclasses provide the specific implementations (API methods).

## Creating a Similar Package

If you want to create a similar package for another API or service, follow these steps:

### 1. Set Up the Project Structure

Create a directory structure similar to the one described above:

```
your_package/
├── docs/
├── examples/
├── src/
│   ├── Api/
│   ├── Client/
│   └── YourAPI.php
├── tests/
├── composer.json
└── README.md
```

### 2. Define the Client Interface

Create a client class that handles the communication with the API. This could be a REST client, WebSocket client, or any other protocol required by the API.

```php
namespace YourNamespace\Client;

class YourClient
{
    // Properties for API credentials, endpoints, etc.
    
    public function __construct($apiKey, $endpoint, $options = [])
    {
        // Initialize the client
    }
    
    public function sendRequest(array $params)
    {
        // Send the request to the API
        // Parse and return the response
    }
    
    public function disconnect()
    {
        // Clean up resources if needed
    }
}
```

### 3. Create the API Interface and Base Class

Define an interface that all API handlers must implement, and a base class that provides common functionality.

```php
namespace YourNamespace\Api;

interface ApiInterface
{
    public function sendRequest(array $params);
}

abstract class BaseApi implements ApiInterface
{
    protected $client;
    
    public function __construct($client)
    {
        $this->client = $client;
    }
    
    public function sendRequest(array $params)
    {
        return $this->client->sendRequest($params);
    }
}
```

### 4. Implement API Handlers

Create classes for each domain of the API, extending the base class.

```php
namespace YourNamespace\Api;

class Users extends BaseApi
{
    public function getUser($userId)
    {
        return $this->sendRequest([
            'method' => 'get_user',
            'user_id' => $userId
        ]);
    }
    
    public function createUser(array $userData)
    {
        return $this->sendRequest(array_merge(
            ['method' => 'create_user'],
            $userData
        ));
    }
    
    // Other user-related methods
}
```

### 5. Create the Main Entry Point

Create a main class that serves as the entry point and facade for your API.

```php
namespace YourNamespace;

use YourNamespace\Client\YourClient;
use YourNamespace\Api\Users;
use YourNamespace\Api\Products;
// Other API handlers

class YourAPI
{
    private $client;
    private $users;
    private $products;
    // Other API handlers
    
    public function __construct($apiKey, $options = [])
    {
        $endpoint = $options['endpoint'] ?? 'https://api.example.com';
        $this->client = new YourClient($apiKey, $endpoint, $options);
    }
    
    public function users()
    {
        if (!$this->users) {
            $this->users = new Users($this->client);
        }
        
        return $this->users;
    }
    
    public function products()
    {
        if (!$this->products) {
            $this->products = new Products($this->client);
        }
        
        return $this->products;
    }
    
    // Other API handler getters
    
    public function disconnect()
    {
        $this->client->disconnect();
    }
}
```

### 6. Write Tests

Create tests for your API handlers and client to ensure they work as expected.

### 7. Create Examples

Write example scripts that demonstrate how to use your package.

### 8. Document Your Package

Create comprehensive documentation that explains how to install and use your package.

## Best Practices

When creating a similar package, follow these best practices:

1. **Use Dependency Injection**: Inject dependencies rather than creating them inside classes.
2. **Follow SOLID Principles**: Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion.
3. **Use Interfaces**: Define interfaces for your classes to make them more testable and flexible.
4. **Implement Lazy Loading**: Only create objects when they're needed.
5. **Handle Errors Gracefully**: Provide meaningful error messages and handle exceptions properly.
6. **Document Your Code**: Use PHPDoc comments to document your classes and methods.
7. **Write Tests**: Create unit tests for your classes to ensure they work as expected.
8. **Provide Examples**: Create example scripts that demonstrate how to use your package.

## Dependencies

When creating a similar package, you'll need to choose appropriate dependencies for your specific use case. For a WebSocket API like Deriv, the package uses:

- **phrity/websocket**: A WebSocket client for PHP
- **ext-json**: PHP's JSON extension for encoding/decoding JSON

For other types of APIs, you might need different dependencies:

- **guzzlehttp/guzzle**: For REST APIs
- **symfony/http-client**: Another option for HTTP APIs
- **react/http**: For asynchronous HTTP requests
- **amphp/http-client**: Another asynchronous HTTP client

Choose dependencies that are well-maintained, have good documentation, and meet your performance requirements.

## Conclusion

By following the architecture and design patterns described in this guide, you can create a clean, maintainable, and user-friendly PHP package for any API or service. The key is to separate concerns, use appropriate design patterns, and provide a simple, intuitive interface for your users.