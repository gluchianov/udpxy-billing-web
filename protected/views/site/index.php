<h2>Статус биллинга:</h2>
<table class="table table-responsive table-striped table-bordered table-hover ">
    <tbody>
        <tr>
            <td>Последняя активность:</td>
            <td><?php
                if ($status==true)
                    echo '<span class="yes">NORMAL</span>';
                else echo '<span class="no">PROBLEM</span>';
            ?></td>
        </tr>
        <!--- На будущее
        <tr>
            <td>Клиентов всего:</td>
            <td>0</td>
        </tr>
        --->
    </tbody>
</table>