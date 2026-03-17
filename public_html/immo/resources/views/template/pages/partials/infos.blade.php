@include('template.components.card-info',[
    'ref'=>$annonce->ref,
    'title'=>'Annonce'
])
@include('template.components.card-info',[
    'ref'=>$annonce->type_immo?$annonce->type_immo->name:'',
    'title'=>'Immo'
])
@include('template.components.card-info',[
    'ref'=>$annonce->created_at->format('Y-m-d'),
    'title'=>'Date publication',
    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 7.25a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm-1 5.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0 3.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m2.5-2.5a1 1 0 1 0 0-2a1 1 0 0 0 0 2m1 2.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m2.5-2.5a1 1 0 1 0 0-2a1 1 0 0 0 0 2"/><path fill="currentColor" fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v1h7V4a.5.5 0 0 1 1 0v1.003q.367.003.654.026c.365.03.685.093.981.243a2.5 2.5 0 0 1 1.092 1.093c.151.296.214.616.244.98c.029.355.029.792.029 1.334v7.642c0 .542 0 .98-.029 1.333c-.03.365-.093.685-.244.981a2.5 2.5 0 0 1-1.092 1.092c-.296.151-.616.214-.98.244c-.355.029-.792.029-1.333.029H8.179c-.542 0-.98 0-1.333-.029c-.365-.03-.685-.093-.981-.244a2.5 2.5 0 0 1-1.093-1.092c-.15-.296-.213-.616-.243-.98C4.5 17.3 4.5 16.862 4.5 16.32V8.68c0-.475 0-.868.02-1.197l.009-.136c.03-.365.093-.685.243-.981a2.5 2.5 0 0 1 1.093-1.093c.296-.15.616-.213.98-.243q.289-.023.655-.026V4a.5.5 0 0 1 .5-.5m-.5 3v-.497a9 9 0 0 0-.573.023c-.302.024-.476.07-.608.137a1.5 1.5 0 0 0-.656.656c-.067.132-.113.306-.137.608C5.5 7.736 5.5 8.132 5.5 8.7v.55h13V8.7c0-.568 0-.964-.026-1.273c-.024-.302-.07-.476-.137-.608a1.5 1.5 0 0 0-.656-.656c-.132-.067-.306-.113-.608-.137a9 9 0 0 0-.573-.023V6.5a.5.5 0 0 1-1 0V6h-7v.5a.5.5 0 0 1-1 0m11 3.75h-13v6.05c0 .568 0 .965.026 1.273c.024.302.07.476.137.608a1.5 1.5 0 0 0 .656.656c.132.067.306.113.608.137C7.236 19 7.632 19 8.2 19h7.6c.568 0 .965 0 1.273-.026c.302-.024.476-.07.608-.137a1.5 1.5 0 0 0 .656-.656c.067-.132.113-.306.137-.608c.026-.308.026-.705.026-1.273z" clip-rule="evenodd"/></svg>'
])
@include('template.components.card-info',[
    'ref'=>$annonce->immo?->type_location?->name ?? ($annonce->typeLocation?->name ?? ''),
    'title'=>"Statut de l'annonce"
])
@include('template.components.card-info',[
    'ref'=>$annonce->ref ?? '',
    'title'=>"Chambre"
])
@include('template.components.card-info',[
    'ref'=>$annonce->immo?->supercie ?? ($annonce->superficie ?? ''),
    'title'=>"Brut / Net M²"
])
@include('template.components.card-info',[
    'ref'=>'---',
    'title'=>"Age du batiment"
])
@include('template.components.card-info',[
    'ref'=>$annonce->immo?->level?->name ?? '',
    'title'=>"Emplacement de l'étage"
])
@include('template.components.card-info',[
    'ref'=>$annonce->adresse,
    'title'=>"Adresse",
    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M12 4a3 3 0 1 0 0 6a3 3 0 0 0 0-6M7 7a5 5 0 1 1 6 4.9V17a1 1 0 1 1-2 0v-5.1A5 5 0 0 1 7 7m2.489 9.1a1 1 0 0 1-.838 1.14c-1.278.194-2.293.489-2.96.815c-1.22.597.206 1.026.95 1.258C7.968 19.728 9.863 20 12 20s4.032-.272 5.359-.687c.749-.234 2.17-.66.95-1.258c-.667-.326-1.682-.62-2.96-.815a1 1 0 1 1 .301-1.977c1.388.21 2.622.547 3.539.996c.884.433 1.811 1.162 1.811 2.241c0 .811-.524 1.4-1.034 1.777C17.816 21.865 14.536 22 12 22c-2.282 0-4.387-.288-5.955-.778C4.795 20.832 3 20.062 3 18.5c0-1.08.927-1.808 1.811-2.24c.917-.45 2.152-.786 3.538-.997a1 1 0 0 1 1.14.838Z"/></g></svg>'
])
@include('template.components.card-info',[
    'ref'=>$annonce->url_video,
    'title'=>"Video",
    'link'=>true,
    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.93 42.5a4.06 4.06 0 0 1-2-.53a4 4 0 0 1-2-3.46v-29a4 4 0 0 1 6-3.46l25.13 14.49a4 4 0 0 1 0 6.92L15.93 42a4.07 4.07 0 0 1-2 .5m4-26.1v15.2L31.08 24ZM31.08 24l7.99-4.61m-29.13-7.6l7.99 4.61m0 15.2v9.21" stroke-width="1"/></svg>'
])
@include('template.components.card-info',[
    'ref'=>$annonce->visite_virtuelle,
    'title'=>"Visite Virtuelle",
    'link'=>true,
    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M20.826 10a3.01 3.01 0 0 0-1.955-1.871A3.005 3.005 0 0 0 16 6H8a3.005 3.005 0 0 0-2.871 2.129A3.01 3.01 0 0 0 3.174 10H2v4h1.174a3.01 3.01 0 0 0 1.955 1.871A3.01 3.01 0 0 0 8 18h1.605l1.891-3.275a.582.582 0 0 1 1.008 0L14.396 18H16a3.01 3.01 0 0 0 2.871-2.129A3.01 3.01 0 0 0 20.826 14H22v-4ZM19 13a1 1 0 0 1-1 1h-1v1a1 1 0 0 1-1 1h-.45l-1.314-2.275a2.582 2.582 0 0 0-4.472 0L8.45 16H8a1 1 0 0 1-1-1v-1H6a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h1V9a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v1h1a1 1 0 0 1 1 1Z"/><path fill="currentColor" d="M15 11H9v-1h6Z"/></svg>'
])