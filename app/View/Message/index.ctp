<h1>List of Users</h1>

<ul>
    <?php foreach ($profile as $profiles): ?>
        <li><?php echo $profiles['Profile']['user_id']; ?></li>
    <?php endforeach; ?>
</ul>
