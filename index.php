<?php 
include("php/database.php");
$query = $db->prepare("SELECT * FROM roles");
$query->execute();
$roles = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rôles - League of Legends</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a1428 0%, #1e2328 50%, #0a1428 100%);
            color: #f0e6d2;
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(90deg, rgba(200, 170, 110, 0.03) 0px, transparent 1px, transparent 40px, rgba(200, 170, 110, 0.03) 41px),
                repeating-linear-gradient(0deg, rgba(200, 170, 110, 0.03) 0px, transparent 1px, transparent 40px, rgba(200, 170, 110, 0.03) 41px);
            pointer-events: none;
            z-index: 1;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 50px;
            background: linear-gradient(135deg, #c89b3c 0%, #f0e6d2 50%, #c89b3c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 2;
            font-weight: 700;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #c89b3c, transparent);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .add-form {
            background: rgba(16, 26, 38, 0.8);
            padding: 30px;
            border-radius: 10px;
            border: 2px solid rgba(200, 155, 60, 0.3);
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(200, 155, 60, 0.1);
            backdrop-filter: blur(10px);
            margin-bottom: 40px;
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }

        .add-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #c89b3c, transparent);
        }

        .form-group {
            flex: 1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #c89b3c;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            background: rgba(9, 14, 22, 0.9);
            border: 2px solid rgba(200, 155, 60, 0.3);
            border-radius: 5px;
            color: #f0e6d2;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #c89b3c;
            box-shadow: 
                0 0 20px rgba(200, 155, 60, 0.2),
                inset 0 1px 3px rgba(0, 0, 0, 0.3);
            background: rgba(9, 14, 22, 1);
        }

        .btn-add {
            padding: 15px 30px;
            background: linear-gradient(135deg, #c89b3c 0%, #f0e6d2 50%, #c89b3c 100%);
            background-size: 200% 100%;
            border: none;
            border-radius: 5px;
            color: #0a1428;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 5px 20px rgba(200, 155, 60, 0.3);
            white-space: nowrap;
        }

        .btn-add:hover {
            background-position: 100% 0;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(200, 155, 60, 0.5);
        }

        .btn-add:active {
            transform: translateY(0);
        }

        .roles-table {
            background: rgba(16, 26, 38, 0.8);
            border-radius: 10px;
            border: 2px solid rgba(200, 155, 60, 0.3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, rgba(200, 155, 60, 0.2), rgba(200, 155, 60, 0.1));
        }

        th {
            padding: 20px;
            text-align: left;
            color: #c89b3c;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            border-bottom: 2px solid rgba(200, 155, 60, 0.3);
        }

        tbody tr {
            border-bottom: 1px solid rgba(200, 155, 60, 0.1);
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: rgba(200, 155, 60, 0.05);
        }

        td {
            padding: 18px 20px;
            color: #f0e6d2;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-right: 5px;
        }

        .btn-edit {
            background: linear-gradient(135deg, rgba(60, 120, 200, 0.3), rgba(60, 120, 200, 0.2));
            border: 1px solid rgba(60, 120, 200, 0.5);
            color: #5ab9ff;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, rgba(60, 120, 200, 0.5), rgba(60, 120, 200, 0.3));
            border-color: #5ab9ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(60, 120, 200, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, rgba(200, 60, 60, 0.3), rgba(200, 60, 60, 0.2));
            border: 1px solid rgba(200, 60, 60, 0.5);
            color: #ff6b6b;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, rgba(200, 60, 60, 0.5), rgba(200, 60, 60, 0.3));
            border-color: #ff6b6b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(200, 60, 60, 0.3);
        }

        .id-badge {
            display: inline-block;
            background: rgba(200, 155, 60, 0.1);
            border: 1px solid rgba(200, 155, 60, 0.3);
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            color: #c89b3c;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
                letter-spacing: 2px;
            }

            .add-form {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-add {
                width: 100%;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 12px 10px;
            }

            .action-btn {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="page-title">Gestion des Rôles</h1>

        <form action="./php/addRole.php" method="POST" class="add-form">
            <div class="form-group">
                <label for="role_name" class="form-label">Nom du Rôle</label>
                <input type="text" name="role_name" id="role_name" class="form-input" placeholder="Ex: Top, Jungle, Mid..." required>
            </div>
            <button type="submit" class="btn-add">Ajouter</button>
        </form>

        <div class="roles-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($roles as $role): ?>
                    <tr>
                        <td><span class="id-badge">#<?php echo $role['id']; ?></span></td>
                        <td><?php echo htmlspecialchars($role['libelle']); ?></td>
                        <td>
                            <a href="./pages/updateRole.php?id=<?php echo $role['id']; ?>" class="action-btn btn-edit" title="Modifier">✏</a>
                            <a href="./php/deleteRole.php?id=<?php echo $role['id']; ?>" class="action-btn btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?');">×</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>