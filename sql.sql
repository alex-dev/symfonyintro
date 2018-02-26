SELECT *
FROM Items i
    INNER JOIN Memories p ON p.id = i.product
    INNER JOIN QuantityScalars s ON s.id = p.size
        INNER JOIN QuantityUnits su ON su.id = s.unit
        INNER JOIN QuantityConverters sc ON sc.id = su.converter
WHERE s.value * sc.factor BETWEEN 0 AND 8 * 8 * POW(10, 9)
