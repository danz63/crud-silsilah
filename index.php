<?php
require 'Person.php';
$person = new Person;
$page = isset($_GET['page']) ? $_GET['page'] : 'index';
if ($page == 'create') {
    $data = $person->index();
} elseif ($page == 'edit') {
    $data = $person->index();
    $person_data = $person->show();
} else {
    $data = $person->$page();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>CRUD Silsilah Keluarga</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Danz63</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Person</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=tree">Tree Person</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <?php if ($page == 'index') : ?>
                    <div class="row mb-2">
                        <div class="col">
                            <h3>Data Silsilah Keluarga</h3>
                        </div>
                        <div class="col text-right">
                            <a href="index.php?page=create" class="btn btn-primary">+ Tambah Data</a>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Nama Orang Tua</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) : ?>
                                <tr>
                                    <th scope="row"><?= array_search($d, $data) + 1 ?></th>
                                    <td><?= $d['name'] ?></td>
                                    <td><?= $d['gender'] ?></td>
                                    <td><?= isset($d['parent_id']) ? ($person->show($d['parent_id'])['name']) : '-' ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                            <a href="index.php?page=edit&person_id=<?= $d['person_id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="index.php?page=destroy&person_id=<?= $d['person_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin Ingin Menghapus data <?= $d['name'] ?> ?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php if ($page == 'create') : ?>
                    <?php
                    $person_id = (!empty($data)) ? ++$data[count($data) - 1]['person_id'] : '1';
                    ?>
                    <div class="row">
                        <div class="col-6 offset-3 border border-primary rounded p-3">
                            <h3>Tambah Data Silsilah Keluarga</h3>
                            <form method="POST" action="index.php?page=store">
                                <input type="hidden" name="person_id" value="<?= $person_id; ?>">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="laki" name="gender" class="custom-control-input" value="Laki-Laki" checked="checked">
                                        <label class="custom-control-label" for="laki">Laki Laki</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" id="perempuan" name="gender" class="custom-control-input" value="Perempuan">
                                        <label class="custom-control-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="name">Nama Orang Tua</label>
                                    <select class="custom-select" name="parent_id" required>
                                        <option value="null">Tidak Dipilih</option>
                                        <?php foreach ($data as $d) : ?>
                                            <option value="<?= $d['person_id']; ?>"><?= $d['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="index.php" class="btn btn-warning">Kembali</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                if ($page == 'store') :
                    if ($data > 0) {
                        echo "<script>alert('data berhasil ditambahkan');</script>";
                        echo "<script>window.location='index.php';</script>";
                    } else {
                        echo "<script>alert('data gagal ditambahkan');</script>";
                        echo "<script>window.history.back();</script>";
                    }
                endif;
                ?>
                <?php if ($page == 'edit') : ?>
                    <div class="row">
                        <div class="col-6 offset-3 border border-primary rounded p-3">
                            <h3>Ubah Data Silsilah Keluarga</h3>
                            <form method="POST" action="index.php?page=update">
                                <input type="hidden" name="person_id" value="<?= $person_data['person_id']; ?>">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $person_data['name']; ?>" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="laki" name="gender" class="custom-control-input" value="Laki-Laki" checked="checked">
                                        <label class="custom-control-label" for="laki">Laki Laki</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" id="perempuan" name="gender" class="custom-control-input" value="Perempuan" <?= $person_data['gender'] == 'Perempuan' ? 'checked="checked"' : ""; ?>>
                                        <label class="custom-control-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="name">Nama Orang Tua</label>
                                    <select class="custom-select" name="parent_id" required>
                                        <option value="null">Tidak Dipilih</option>
                                        <?php foreach ($data as $d) : ?>
                                            <option value="<?= $d['person_id']; ?>" <?= $person_data['parent_id'] == $d['person_id'] ? 'selected' : ''; ?>><?= $d['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="index.php" class="btn btn-warning">Kembali</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                if ($page == 'destroy') :
                    if ($data > 0) {
                        echo "<script>alert('data berhasil dihapus');</script>";
                        echo "<script>window.location='index.php';</script>";
                    } else {
                        echo "<script>alert('data gagal dihapus');</script>";
                        echo "<script>window.history.back();</script>";
                    }
                endif;
                ?>
                <?php
                if ($page == 'update') :
                    if ($data > 0) {
                        echo "<script>alert('data berhasil diubah');</script>";
                        echo "<script>window.location='index.php';</script>";
                    } else {
                        echo "<script>alert('data gagal diubah');</script>";
                        echo "<script>window.history.back();</script>";
                    }
                endif;
                ?>

            </div>
        </div>
    </div>
    <?php if ($page == 'tree') : ?>
        <link rel="stylesheet" href="node_modules/treant-js/Treant.css">
        <link rel="stylesheet" href="node_modules/treant-js/examples/basic-example/basic-example.css">
        <div class="bg-light">
            <div class="row p-5">
                <div class="col text-center">
                    <h2 style="font-weight: bold; font-size: 25px;">Tree Virtualization</h2>
                </div>
                <div class="col text-right mr-5">
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </div>
            </div>
            <div id="basic-example" style="height: 60vh;">
            </div>
        </div>
        <script src="node_modules/treant-js/vendor/jquery.min.js"></script>
        <script src="node_modules/treant-js/vendor/raphael.js"></script>
        <script src="node_modules/treant-js/Treant.js"></script>
        <script>
            var config = {
                    container: "#basic-example",
                    connectors: {
                        type: 'step'
                    },
                    node: {
                        HTMLclass: 'nodeExample1'
                    }
                },
                <?= $data['res']; ?>


            chart_config = [
                config,
                <?= $data['conf']; ?>
            ];

            var my_chart = new Treant(chart_config);
        </script>
    <?php endif; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>