<div class="row pt-5">
    <div class="col-lg-3" align="center">
        <h1>Filtering</h1>
        <hr class="mb-5">
        <form action="" id="filteringForm">
            <div class="input-group mb-3">
                <span class="input-group-text" id="email-label">email</span>
                <input type="text" class="form-control" value="<?=$history["email"] ?>" placeholder="Enter searched email here..." name="email" >
            </div>
            <label for="date-sorting">Sort By </label>
            <select class="form-select mb-3" name="sorting-column">
                    <option value="" disabeled selected>Sort by</option>
                <?php foreach ($filteringColumns as $column):?>
                    <option value=<?=$column?> <?= $history["sorting-column"] == $column? ' selected="selected"' : '' ?> ><?=$column?></option>
                <?php endforeach;?>
                </select>
            <label for="name-sorting">Sorting order</label>
            <select class="form-select mb-3" name="sorting-order">
                <option value="" disabeled selected>Sort by name</option>
                <?php foreach ($filteringOrder as $order):?>
                <option value=<?=$order?> <?= $history["sorting-order"] == $order? ' selected="selected"' : '' ?> ><?=$order?></option>
                <?php endforeach;?>
            </select>
            <label for="provider-filtering">Filter by Provider</label>
            <select class="form-select mb-3" name="provider-filtering">
                <option value="" disabeled selected>Filter by provider</option>
                <?php foreach ($providers as $provider):?>
                <option value=<?=$provider["id"]?> <?= $history["provider-filtering"] == $provider["id"]? ' selected="selected"' : '' ?> ><?=$provider["providerName"]?></option>
                <?php endforeach;?>
            </select>
            <button class="btn btn-primary mt-2 w-100" type="submit" form="filteringForm">Filter</button>
        </form>

        <h1 class="mt-5">Actions</h1>
        <hr class="mb-5">
        <button class="btn btn-danger w-100" type="submit" form="tableForm">Delete Selected Items</button>

    </div>
    <div class="col-lg-9 gx-5">
        <form name="tableForm" action="/deleteEmails" method="post" id="tableForm">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Selected</th>
                    <th scope="col">Email </th>
                    <th scope="col">Provider</th>
                    <th scope="col">Subscribed at</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><input type="checkbox" name="<?= $user["id"] ?>"></td>
                        <td><?= $user["email"] ?></td>
                        <td><?= $user["providerName"]?></td>
                        <td><?= $user["created_at"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

</div>