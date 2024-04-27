 const multiOperationsItems = document.querySelector('.multi-operations');
 // The two checkboxes (top and bottom) that select all checkboxes
 const checkboxesAllLeads = document.querySelectorAll('.checkbox-all-leads');
 const checkboxesLead = document.querySelectorAll('.lead-checkbox');
 let leadsIds = [];

 checkboxesAllLeads.forEach((checkboxAllLeads) => {
     checkboxAllLeads.addEventListener('change', function() {
         if (this.checked) {
             checkboxesAllLeads.forEach((ele) => ele.checked = true);
             checkboxesLead.forEach((checkbox) => {
                 checkbox.checked = true;
             })
         } else {
             checkboxesAllLeads.forEach((ele) => ele.checked = false);
             checkboxesLead.forEach((checkbox) => {
                 checkbox.checked = false;
             })
         }

         setLeadsIds();
     });
 })

 checkboxesLead.forEach((checkbox) => {
     checkbox.addEventListener('change', function() {
         if (this.checked) {
             checkboxesAllLeads.forEach((ele) => ele.checked = true);
         } else {
             const countOfChecked = document.querySelectorAll('.lead-checkbox:checked').length;

             if (countOfChecked == 0) {
                 checkboxesAllLeads.forEach((ele) => ele.checked = false);
             }
         }

         setLeadsIds();
     })
 })

 function setLeadsIds() {
     const checkedCheckboxes = document.querySelectorAll('.lead-checkbox:checked');
     leadsIds = [];
     checkedCheckboxes.forEach((ele) => {
         leadsIds.push(ele.value);
     });

     showAndHideMultiOperationsItems();
     setLinksToView();
     setLeadsIdsHiddenInput();
 }

 function showAndHideMultiOperationsItems() {
    if(leadsIds.length) {
        multiOperationsItems.classList.remove('d-none');
     } else {
        multiOperationsItems.classList.add('d-none');
     }
 }

 function setLinksToView() {
    const multiOperationsLinksToView = document.querySelectorAll('.multi-operations .link-to-view');

    multiOperationsLinksToView.forEach(link => {
        if (leadsIds.length) {
            const route = link.dataset.route;
            link.href = `${route}?leads_ids=${leadsIds.join(',')}`;
        } else {
            link.href = "javascript:void(0)";
        }
    })
 }

 function setLeadsIdsHiddenInput() {
    const leads_ids_hidden_inputs = document.querySelectorAll('.leads_ids_hidden_inputs');

    console.log('====================================');
    console.log(leads_ids_hidden_inputs);
    console.log('====================================');
    leads_ids_hidden_inputs.forEach(input => input.value = leadsIds.join(','));
 }

 