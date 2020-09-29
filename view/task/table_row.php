<tr>
    <td><?=$task->username?></td>
    <td><?=$task->mail?></td>
    <td><?=nl2br($task->text)?></td>
    <td>
        <? if(!empty($task->status)):?>
            <span class="badge badge-success">Выполнена</span>
        <? else: ?>
            <span class="badge badge-warning">Не выполнена</span>
        <? endif; ?>
    </td>
</tr>