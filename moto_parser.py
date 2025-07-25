import pandas as pd
import json
import os
from datetime import datetime

def parse_moto_prices(file_path: str, output_format: str = 'json'):
    start_time = datetime.now()
    print(f"\n=== Начало обработки {start_time.strftime('%Y-%m-%d %H:%M:%S')} ===")
    print(f"Обрабатываем файл: {file_path}")
    
    if not os.path.exists(file_path):
        print(f"❌ Ошибка: Файл '{file_path}' не найден!")
        print(f"Текущая рабочая папка: {os.getcwd()}")
        print("Содержимое папки:")
        for f in os.listdir():
            print(f"- {f}")
        return

    try:
        print("Загружаем данные из Excel...")
        df = pd.read_excel(file_path, sheet_name='Мототехника', header=None, skiprows=4)
        print(f"Загружено строк: {len(df)}")

        # Автоматически определяем все категории
        all_categories = set()
        for _, row in df.iterrows():
            cell = str(row[0]).strip()
            if "Скутеры" in cell or "Мопеды" in cell or "Мотоциклы" in cell or "Грузовой" in cell or "Комплектующие" in cell:
                all_categories.add(cell)
        
        print("\nНайдены категории:")
        for cat in sorted(all_categories):
            print(f"- {cat}")

        # Создаем динамический словарь категорий
        categories = {cat: [] for cat in all_categories}
        
        current_category = ""
        current_model = {}
        processed_models = 0
        
        print("\nОбработка данных...")
        for idx, row in df.iterrows():
            if idx % 50 == 0 and idx > 0:
                print(f"Обработано {idx}/{len(df)} строк...")
            
            col_a = str(row[0]).strip() if pd.notna(row[0]) else ""
            col_c = str(row[2]).strip() if pd.notna(row[2]) else ""
            col_d = str(row[3]).strip() if pd.notna(row[3]) else ""
            col_e = row[4]
            col_f = row[5]
            
            # Определяем категорию
            if col_a in categories:
                current_category = col_a
                print(f"\nОбрабатываем категорию: {current_category}")
                continue
            
            # Пропускаем пустые строки
            if not col_a and not col_c:
                continue
                
            # Обработка новой модели
            if col_a and not col_a.startswith(("Примечание", "Цветовая")):
                if current_model and current_category:
                    categories[current_category].append(current_model)
                    processed_models += 1
                    
                current_model = {
                    "model": col_a,
                    "specs": {},
                    "dealer_price": None,
                    "retail_price": None,
                    "notes": [],
                    "colors": ""
                }
                continue
            
            # Обработка цветовой гаммы
            if "Цветовая гамма" in col_a:
                current_model["colors"] = col_a.replace("Цветовая гамма:", "").strip()
                continue
                
            # Обработка примечаний
            if "Примечание" in col_a:
                current_model["notes"].append(col_a.replace("Примечание:", "").strip())
                continue
                
            # Обработка характеристик
            if col_c and col_d:
                # Особый случай для цены
                if "Колесная база" in col_c:
                    try:
                        current_model["dealer_price"] = float(col_e)
                        current_model["retail_price"] = float(col_f)
                    except (TypeError, ValueError):
                        pass
                        
                # Сохраняем характеристику
                current_model["specs"][col_c] = col_d

        if current_model and current_category:
            categories[current_category].append(current_model)
            processed_models += 1
        
        print(f"\nУспешно обработано моделей: {processed_models}")
        
        # Экспорт результатов
        output_file = f'moto_prices.{output_format}'
        print(f"\nСохранение результатов в {output_file}...")
        
        if output_format == 'json':
            with open(output_file, 'w', encoding='utf-8') as f:
                json.dump(categories, f, ensure_ascii=False, indent=2)
        elif output_format == 'csv':
            all_models = []
            for category, models in categories.items():
                for model in models:
                    model_data = {
                        "category": category,
                        "model": model["model"],
                        "dealer_price": model["dealer_price"],
                        "retail_price": model["retail_price"],
                        "colors": model["colors"]
                    }
                    # Добавляем характеристики
                    for key, value in model["specs"].items():
                        model_data[key] = value
                    # Добавляем примечания
                    model_data["notes"] = "; ".join(model["notes"])
                    all_models.append(model_data)
            
            pd.DataFrame(all_models).to_csv(output_file, index=False, encoding='utf-8-sig')
        
        if os.path.exists(output_file):
            print(f"✅ Файл {output_file} успешно создан!")
            print(f"Размер: {os.path.getsize(output_file)/1024:.2f} KB")
        else:
            print("❌ Файл результатов не был создан!")

    except KeyError as e:
        print(f"\n❌ Критическая ошибка: Не найдена категория - {str(e)}")
        print("Возможные причины:")
        print("1. Новая категория не была автоматически определена")
        print("2. Ошибка в структуре файла")
        print("\nСовет: Проверьте файл Excel - возможно, есть опечатки в названиях категорий")
        
    except Exception as e:
        print(f"\n❌ Неожиданная ошибка: {str(e)}")
        print("Тип ошибки:", type(e).__name__)
        
    finally:
        print(f"\n=== Обработка завершена ===")
        print(f"Время выполнения: {(datetime.now() - start_time).total_seconds():.2f} сек")

if __name__ == "__main__":
    FILE_PATH = 'Прайс на мототехнику RACER 2025 (01.07.2025).xls'
    parse_moto_prices(FILE_PATH, output_format='json')