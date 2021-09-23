export function toggleSideMenu ( state, value ){
    state.isSideMenuOpen = value
}
export function setUI ( state, ui ){
    state.userUI = ui
}
export function setNavList ( state, navlist ){
    state.NavLists = navlist
}
export function setAvatar ( state, avatar ){
    state.userUI.avatar = avatar
}
export function setUserName ( state, user ){
    state.userUI.user = user
}