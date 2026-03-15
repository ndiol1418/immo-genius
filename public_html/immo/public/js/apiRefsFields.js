if(fields.length > 0) {

    fields.forEach(field => {
        let url = field.ref;
        if(field && field.type_field_id == 5 && url && url.trim() !== '') {
            sendrequest(field);
        }
    });


}

function sendrequest(field) {
    let url = field.ref;
    let selectREF = `#info${field.id}`;
    let info = field.info;
    let initialHTML = $(selectREF).html();

    $(selectREF).html(`<option default value="">Chargement ...</option>`);
    $(selectREF).prop('disabled', true);

    $.post(
        url,
        {},
        function (data, textStatus, xhr) {
        if (textStatus == "success") {
            if (data != null) {
                $(selectREF).html(buildSelect(data, info, field));
                buildSuccess(selectREF, `La récupération données #${field.name}# a réussi.`);
            } else {
                    buildError(selectREF, `La récupération données #${field.name}# a échoué.`);
                    $(selectREF).html(initialHTML);
                }
            }
        }
    ).fail(
        () => {
            buildError(selectREF, `La récupération données #${field.name}# a échoué.`);
            $(selectREF).html(initialHTML);
        }
    );
}

function buildError(ref, errorMsg) {
    $(ref).addClass('is-invalid');
    $(ref).prop('disabled', false);
    $(ref).after(`
        <span class="invalid-feedback" role="alert">
            <strong>${errorMsg}</strong>
        </span>`);
}

function buildSuccess(ref, successMsg) {
    // $(ref).addClass('is-valid');
    $(ref).prop('disabled', false);
    // $(ref).after(`
    //     <span class="valid-feedback" role="alert">
    //         <strong>${successMsg}</strong>
    //     </span>`);
}

function buildSelect(options, info, field) {
    let messageHTML = `<option value>Sélectionner : ${field.name}</option>`;
    for (const index in options) {
        if (options.hasOwnProperty(index)) {
            const value = options[index];
            messageHTML += `<option value="${index}" ${info && info.value == index ? "selected" : ""}>${value}</option>`;
        }
    }
    return messageHTML;
}
