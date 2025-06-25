<h1>Курсы валют</h1>

<p>Базовая валюта: <?= htmlspecialchars($data['base']); ?></p>

<form method="GET" action="/base">
    <label for="currency">Сменить базовую валюту:</label>
    <input type="text" name="currency" id="currency" placeholder="например: USD" required>
    <button type="submit">Сменить</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>Валюта</th>
        <th>Курс</th>
    </tr>
    <?php foreach ($data['rates'] as $currency => $rate): ?>
        <tr>
            <td><?= htmlspecialchars($currency) ?></td>
            <td><?= htmlspecialchars($rate) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
