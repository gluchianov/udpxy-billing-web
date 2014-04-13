<h3>Открытые подписки:</h3>
<table class="table table-bordered table-striped">
    <thead><tr>
        <th>Название подписки</th>
        <th>Дата начала подписки</th>
        <th>Дата окончания подписки</th>
    </tr></thead>
    <tbody>
    <?php
    if ($allowed_list==NULL){echo '<tr><td colspan="3" style="text-align: center">Нет активных подписок</td></tr>';}
    else
        foreach ($allowed_list as $allowed){ ?>
            <tr>
                <td>
                    <?php echo $allowed->tvpack->name; ?>
                </td>
                <td>
                    <?php echo $allowed->start_date; ?>
                </td>
                <td>
                    <?php echo $allowed->end_date; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>