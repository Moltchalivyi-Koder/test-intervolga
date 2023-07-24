DELETE FROM categories WHERE categories.id NOT IN (SELECT p.category_id FROM products p)
DELETE FROM products WHERE products.id NOT IN (SELECT a.product_id FROM availabilities a)
DELETE FROM stocks WHERE stocks.id NOT IN (SELECT a.stock_id FROM availabilities a);