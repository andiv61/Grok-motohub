const fs = require('fs');

// Пример данных из прайса (замените на реальные данные)
const priceData = {
  "scooters_up_to_50cc": [
    {
      "model": "RACER RC50QT-3 METEOR",
      "article": "RC50QT-3",
      "dealer_price": 66050,
      "retail_price": 79300,
      "stock": 0,
      "category": "Скутеры до 50 см³",
      "specs": {
        "dimensions": "1700x660x1070 мм",
        "engine_volume": "49.5 см³",
        "power": "3.4 л.с.",
        "max_speed": "≥49 км/ч",
        "weight": "74 кг",
        "colors": ["зеленый", "красный", "бирюза", "синий"]
      }
    }
  ],
  "scooters_above_50cc": [
    {
      "model": "RACER RC150T-15X BWS R 150",
      "article": "RC150T-15X",
      "dealer_price": 68000,
      "retail_price": 88400,
      "stock": 0,
      "category": "Скутеры свыше 50 см³",
      "specs": {
        "dimensions": "1960x710x1130 мм",
        "engine_volume": "149.5 см³",
        "power": "8.2 л.с.",
        "max_speed": "≥85 км/ч",
        "weight": "106 кг",
        "colors": ["красный", "серый", "синий"]
      }
    }
  ]
  // Добавьте остальные категории и модели вручную или автоматизируйте парсинг
};

// Сохранение в JSON
fs.writeFile('catalog.json', JSON.stringify(priceData, null, 2), (err) => {
  if (err) throw err;
  console.log('Каталог успешно создан в catalog.json');
});