Feature: Coin inventory management

  Scenario: Successfully create a new coin
    Given i have a coin creation request with the following details:
      | country          | usa                      |
      | description      | American Gold Eagle 1 oz |
      | metal            | Gold                     |
      | name             | American Eagle           |
      | nominal          | 50                       |
      | purchaseCurrency | USD                      |
      | purchaseDate     | 2025-03-10               |
      | purchasePrice    | 286200                   |
      | purity           | 91.67                    |
      | weight           | 31.1                     |
      | year             | 2025                     |
    When I send a PUT request to "/api/inventory"
    Then the response status code should be 201
    And the response should contain the following details, and the fields "purchasePrice, marketMetalPriceValue" should be strings:
      | id                    | @uuid@                    |
      | country               | usa                       |
      | description           | American Gold Eagle 1 oz  |
      | metal                 | gold                      |
      | name                  | American Eagle            |
      | nominal               | 50                        |
      | purchaseCurrency      | USD                       |
      | purchaseDate          | 2025-03-10                |
      | purchasePrice         | 2862.00                   |
      | purity                | 91.67                     |
      | weight                | 31.1                      |
      | year                  | 2025                      |
      | marketMetalPriceValue | 0.00                      |
      | karats                | 22                        |
      | pureMetalWeight       | 28.509370000000004        |
      | purchaseDate          | 2025-03-10T00:00:00+00:00 |

  Scenario: Successfully get list of coins
    Given i have an eagle coin
    And i have a mapleLeaf coin
    And i have a britannia coin
    When I send a GET request to "/api/inventory"
    Then the response status code should be 200
    And the response content should be equal the following data:
    """
    [
        {
            "id": "@uuid@",
            "name": "Maple Leaf",
            "description": "Iconic Canadian gold coin",
            "purchasePrice": "1900.00",
            "purchaseCurrency": "EUR",
            "metal": "gold",
            "weight": 31.1,
            "purity": 99.99,
            "nominal": 50,
            "country": "australia",
            "year": 2022,
            "marketMetalPriceValue": "621.94",
            "karats": 24,
            "pureMetalWeight": 31.09689,
            "purchaseDate": "2023-10-20T09:45:00+02:00"
        },
        {
            "id": "@uuid@",
            "name": "Britannia 1\/2 oz Gold",
            "description": "Gold investment coin",
            "purchasePrice": "1550.00",
            "purchaseCurrency": "EUR",
            "metal": "gold",
            "weight": 15.55,
            "purity": 99.99,
            "nominal": 50,
            "country": "unitedKingdom",
            "year": 2024,
            "marketMetalPriceValue": "310.97",
            "karats": 24,
            "pureMetalWeight": 15.548445,
            "purchaseDate": "2023-12-01T00:15:00+02:00"
        },
        {
            "id": "@uuid@",
            "name": "Golden Eagle",
            "description": "A stunning silver coin from the USA",
            "purchasePrice": "2500.00",
            "purchaseCurrency": "EUR",
            "metal": "gold",
            "weight": 33.93,
            "purity": 91.67,
            "nominal": 1,
            "country": "usa",
            "year": 2023,
            "marketMetalPriceValue": "311.04",
            "karats": 22,
            "pureMetalWeight": 31.103631,
            "purchaseDate": "2023-11-15T14:30:00+02:00"
        }
    ]
    """
