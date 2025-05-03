<!DOCTYPE html>
<html>
<head>
    <title>Submitted Contacts</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        
    </style>
</head>
<body>

<h2>Contact Submissions</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= esc($contact['id']) ?></td>
                    <td><?= esc($contact['name']) ?></td>
                    <td><?= esc($contact['email']) ?></td>
                    <td><?= esc($contact['phone']) ?></td>
                    <td><?= esc($contact['message']) ?></td>
                    <td><?= esc($contact['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No contacts found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
