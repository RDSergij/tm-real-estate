<tr class="themosis-field-container">
    <th class="themosis-label" scope="row">
        <?php echo Form::label($field['features']['title'], array( 'for' => $field['atts']['id'] ) ) ?>
    </th>
    <td class="themosis-field">
        <?php echo $field->metabox() ?>
    </td>
</tr>