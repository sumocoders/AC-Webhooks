{title}Webhooks{/title}
{add_bread_crumb}Webhooks Settings{/add_bread_crumb}

<div id="webhooks" class="page_wrapper">
    {form action=Router::assemble('admin_webhooks') method=post}
        <div class="content_stack_wrapper">
            <div class="content_stack_element last">
                <div class="content_stack_element_info">
                    <h3>{lang}Events{/lang}</h3>

                    <p class="aid">{lang}Use this to link an webhook to an event{/lang}</p>
                </div>
                <div class="content_stack_element_body">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>{lang}Event{/lang}</th>
                                <th>{lang}URL to call{/lang}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$webhooks_data.events item=event}
                                <tr>
                                    <td>
                                        <input type="checkbox" name="enable_{$event.name}" class="auto input_checkbox" value="1" id="enable_{$event.name}" {if $event.enabled}checked="checked"{/if} />
                                    </td>
                                    <td><label for="enable_{$event.name}"></label>{$event.name}</td>
                                    <td>{text_field name="callback_{$event.name}" value=$event.callback id="callback_{$event.name}" class="long required"}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {wrap_buttons}
    {submit}Save Changes{/submit}
    {/wrap_buttons}
    {/form}
</div>
