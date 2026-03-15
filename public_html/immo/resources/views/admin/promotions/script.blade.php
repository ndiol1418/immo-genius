<script>
    $(document).ready(function() {
        $('#promotion-form').submit(function() {
            $(this)[0].reset();
        });

        function displayPromotionFields(selectedType) {
            $('.promotion-fields').hide();
            switch (selectedType) {
                case '1':
                    $('#pourcentage-fields').show();
                    break;
                case '2':
                    $('#montant-fields').show();
                    break;
                case '3':
                    $('#quantite-fields').show();
                    break;
                case '4':
                    $('#minimum-achat-fields').show();
                    break;
            }
        }
        function checkFields() {
            var selectedType = $('input[name="type"]:checked').val();
            switch (selectedType) {
                case '1': // Pourcentage
                    return $('#pourcentage_input').val() !== '' && $('#qte_min_acht_pourcentage').val() !== '';
                case '2': // Montant
                    return $('#montant_input').val() !== '' && $('#qte_min_acht_montant').val() !== '';
                case '3': // Quantité
                    return $('#qte_acht').val() !== '' && $('#qte_off').val() !== '';
                default:
                    return false;
            }
        }

        $('input[name="type"]').change(function() {
            var selectedType = $(this).val();
            displayPromotionFields(selectedType);
            $('.add-promotion').prop('disabled', !checkFields());
        });
        $('.add-promotion').prop('disabled', true)
        $('#pourcentage_input, #montant_input, #qte_acht, #qte_off, #qte_min_acht, #reduction,#qte_min_acht_pourcentage,#qte_min_acht_montant')
            .on('input change', function() {
                $('.add-promotion').prop('disabled', !checkFields());
        });

        var i=0;
        var produitsSet = new Set();
        $('.add-promotion').click(function() {
            var produit_id = $('#produit_id option:selected').val();
            var selectedType = $('input[name="type"]:checked').val();
            var reduction = '';
            var quantiteAcht = '';
            var quantiteOff = '';
            var type_promo = '';
            var designation_produit = $('#produit_id option:selected').text();

            switch (selectedType) {
                case '1': // Pourcentage
                    reduction = parseFloat($('#pourcentage_input').val());
                    quantiteAcht = parseFloat($('#qte_min_acht_pourcentage').val());
                    quantiteOff = 0; // Pourcentage ou montant, donc pas de quantité offerte
                    type_promo = 'Pourcentage';
                    break;
                case '2': // Montant
                    reduction = parseFloat($('#montant_input').val());
                    quantiteAcht = parseFloat($('#qte_min_acht_montant').val());
                    quantiteOff = 0; // Pourcentage ou montant, donc pas de quantité offerte
                    type_promo = 'Montant';
                    break;
                case '3': // Quantité
                    reduction = 0; // Par défaut pour le type Quantité
                    quantiteAcht = parseFloat($('#qte_acht').val());
                    quantiteOff = parseFloat($('#qte_off').val() || 0);
                    type_promo = 'Quantité';
                    break;
            }
            var produitKey = produit_id + '_' + selectedType + '_' + reduction + '_' + quantiteAcht + '_' + quantiteOff;
            if (!produitsSet.has(produitKey) && !produitExistsInTable(produitKey)) {
                var existingRow = null;

                $('table tbody tr').each(function() {
                    var existingDesignation = $(this).find('td:eq(0)').text().trim();
                    var existingType = $(this).find('td:eq(1)').text().trim();
                    var existingReduction = parseFloat($(this).find('td:eq(2)').text());
                    var existingQuantiteAcht = parseFloat($(this).find('td:eq(3)').text());
                    var existingQuantiteOff = parseFloat($(this).find('td:eq(4)').text());

                    if (existingDesignation === designation_produit &&
                        existingType === type_promo &&
                        (existingReduction === 0 || existingQuantiteOff === 0) &&
                        (existingReduction === reduction || existingQuantiteAcht === quantiteAcht ))
                        {
                        existingRow = $(this);
                        updateLine(existingRow, reduction, quantiteAcht,quantiteOff);
                        return false;
                    }
                });
                if (existingRow === null) {
                    addLine(designation_produit, reduction, quantiteAcht, quantiteOff, type_promo, selectedType, produit_id);
                    produitsSet.add(produitKey);
                }
            }

        });
        function produitExistsInTable(produitKey) {
            var exists = false;
            $('table tbody tr').each(function() {
                var existingKey = $(this).find('input[name^="en_promo["]').val();
                if (existingKey === produitKey) {
                    exists = true;
                    return false;
                }
            });
            return exists;
        }
        function addLine(designation_produit, reduction, quantiteAcht, quantiteOff, type_promo, selectedType, produit_id) {
            var cel1 =  '<td>'+designation_produit+'<input type="hidden" name="en_promo['+i+'][produit_id]" value="'+produit_id+'"/></td>';
            var cel2 =  '<td>'+type_promo+'<input type="hidden" name="en_promo['+i+'][type]" value="'+selectedType+'"/></td>';
            var cel3 =  '<td>'+reduction+'<input type="hidden" name="en_promo['+i+'][reduction]" value="'+reduction+'"/></td>';
            var cel4 =  '<td>'+quantiteAcht+'<input type="hidden" name="en_promo['+i+'][qte_acht]" value="'+quantiteAcht+'"/></td>';
            var cel5 =  '<td>'+quantiteOff+'<input type="hidden" name="en_promo['+i+'][qte_off]" value="'+quantiteOff+'"/></td>';
            var cel6 = '<td><i class="fa fa-trash delete-row"></i></td>';
            var ligne = '<tr>'+cel1+cel2+cel3+cel4+cel5+cel6+'</tr>';
            $('table tbody').append(ligne);
            i++;
        }
        function updateLine(existingRow, reduction, quantiteAcht,quantiteOff) {
            existingRow.find('td:eq(2)').text(reduction);
            existingRow.find('td:eq(3)').text(quantiteAcht);
            existingRow.find('td:eq(4)').text(quantiteOff);
        }
        $('table').on('click', '.delete-row', function() {
            if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
                $(this).closest('tr').remove();
            }
        });
        $('body').on('change', '#fournisseur_id', function() {
            var fournisseurId = $(this).val();
            var produits = @json($produits);

            $('#produit_id').empty().append('<option value="">Choisissez un produit</option>');

            var produitsFiltres = produits.filter(function(produit) {
                return produit.fournisseur_id == fournisseurId || fournisseurId === '';
            });

            produitsFiltres.forEach(function(produit) {
                $('#produit_id').append('<option value="' + produit.id + '">' + produit
                    .designation + '</option>');
            });
        });
    });
</script>
