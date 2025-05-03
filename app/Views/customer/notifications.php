<h2>🔔 Notifications</h2>
<ul class="list-group">
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $note): ?>
            <li class="list-group-item">
                <?= esc($note['message']) ?> <br>
                <small class="text-muted"><?= date('d M Y, h:i A', strtotime($note['created_at'])) ?></small>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="list-group-item">No notifications yet.</li>
    <?php endif; ?>
</ul>
