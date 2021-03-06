import { Modal } from './Modal.js?v=10'
import fetch_wrap from './fetch_wrap.js?v=10'
import * as lib from './lib.js?v=10'
import hal from './hal.js?v=10'
import ui from './ui.js?v=10'
import env from './env.js?v=10'
import nav from './nav.js?v=10'

const create = document.querySelector('#create')
const add_team = document.querySelector('#add-team .button')
const add_player = document.querySelector('#add-player .button')
const add_to_team = document.querySelector('#add-to-team .button')
const deletes = document.querySelectorAll('.delete')
const reset_request = document.querySelector('#reset-request form')
const reset_verify = document.querySelector('#reset-verify form')
const reset_password = document.querySelector('#reset-password form')
const confirm_code = document.querySelector('#confirm-code form')
const edit_tournament = document.querySelector('#edit-tournament')

nav()

const is_manager = document.querySelector('body.role-manager') ? true : false
const is_admin = document.querySelector('body.role-admin') ? true : false




const tourney_modal = edit_id => {
	const editing = !( !edit_id && typeof edit_id !== 'number' )
	const modal = new Modal({
		type: 'tournament',
	})
	const form = document.createElement('form')
	const title = document.createElement('h3')
	title.classList.add('modal-title')
	title.innerText = ( editing ? 'edit' : 'create' ) + ' tournament:'
	const name = document.createElement('input')
	name.type = 'text'
	name.placeholder = 'tournament name'
	const date = document.createElement('input')
	date.type = 'text'
	date.placeholder = 'tournament date'
	const description = document.createElement('textarea')
	description.placeholder = 'tournament description (text only)'
	const link = document.createElement('input')
	link.type ='text'
	link.placeholder = 'link (optional)'
	const submit = document.createElement('input')
	submit.classList.add('button')
	submit.type = 'submit'
	submit.value = editing ? 'edit' : 'create'
	const br = document.createElement('br')
	let open, open_desc
	if( editing ){
		open_desc = document.createElement('label')
		open_desc.innerText = 'tournament still open'
		open = document.createElement('input')
		open.type = 'checkbox'
	}
	form.appendChild( title )
	form.appendChild( name )
	form.appendChild( date )
	form.appendChild( description )
	form.appendChild( br )
	form.appendChild( link )
	form.appendChild( br.cloneNode() )
	if( editing ){
		form.appendChild( open_desc )
		form.appendChild( open )
		form.appendChild( br.cloneNode() )
	}
	form.appendChild( submit )
	modal.content.appendChild( form )
	document.body.appendChild( modal.ele )
	form.addEventListener('submit', e => {
		e.preventDefault()
		ui.spinner.show()
		const n = name.value.trim()
		const d = date.value.trim()
		const l = description.value.trim()
		const lnk = link.value.trim()
		const o = open && open.checked
		let route
		if( editing ){
			route = '/server/ajax/update.php'
		}else{
			route = '/server/ajax/create.php'
		}
		fetch_wrap( env.PUBLIC_ROOT + route, 'post', {
			type: 'tournament',
			date: d,
			description: l,
			name: n,
			link: lnk,
			edit_id: edit_id,
			open: o,
		})
		.then( res => {
			if( res.success ){
				hal('success', 'success', 3000 )
				setTimeout(()=>{
					window.location.assign( env.PUBLIC_ROOT )
				}, 500 )
			}else{
				ui.reject( res, res.msg || 'failed to save', 5000 )
			}
		})
		.catch( err => {
			ui.reject( err, err.msg || 'failed to save', 5000 )
		})
	})
	if( editing ){
		const liner = document.querySelector('.main-info-liner')
		if( liner ){	
			const source_title = liner.querySelector('.tournament-title')
			const source_description = liner.querySelector('.tournament-description')
			const source_date = liner.querySelector('.tournament-date')		
			const source_link = liner.querySelector('.tournament-link')
			name.value = source_title.innerHTML || ''
			description.value = source_description.innerHTML || ''
			link.value = source_link.text || ''
			date.value = source_date.innerHTML || ''
			if( open ) open.checked = liner.getAttribute('data-open') ? true : false
		}
	}
}


if( create ){

	const tourney = document.querySelector('#create .tournament')
	const manager = document.querySelector('#create .team-manager')
	const team = document.querySelector('#create .team')
	const player = document.querySelector('#create .player')

	if( tourney ){
		tourney.addEventListener('click', () => {
			tourney_modal()
		})
	}

	if( manager ){
		manager.addEventListener('click', () => {
			const modal = new Modal({
				type: 'manager',
			})
			const form = document.createElement('form')
			const title = document.createElement('h3')
			title.classList.add('modal-title')
			title.innerText = 'create manager:'
			const name = document.createElement('input')
			name.type = 'text'
			name.placeholder = 'first name'
			const surname = document.createElement('input')
			surname.type = 'text'
			surname.placeholder = 'last name'
			const email = document.createElement('input')
			email.type = 'text'
			email.placeholder = 'manager email'
			const password = document.createElement('input')
			password.type = 'text'
			password.placeholder = 'manager password'
			const submit = document.createElement('input')
			submit.classList.add('button')
			submit.type = 'submit'
			submit.value = 'create'
			const br = document.createElement('br')
			form.appendChild( title )
			form.appendChild( name )
			form.appendChild( surname )
			form.appendChild( email )
			form.appendChild( br )
			form.appendChild( submit )
			modal.content.appendChild( form )
			document.body.appendChild( modal.ele )
			form.addEventListener('submit', e => {
				e.preventDefault()
				ui.spinner.show()
				const n = name.value.trim()
				const em = email.value.trim()
				const sn = surname.value.trim()
				fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
					type: 'manager',
					name: n,
					surname: sn,
					email: em,
				})
				.then( res => {
					if( res.success ){
						hal('success', 'success', 3000 )
						modal.ele.remove()
					}else{
						ui.reject( res, res.msg || 'failed to create', 2000 )
					}
				})
				.catch( err => {
					ui.reject( err, err.msg || 'failed to create', 2000 )
				})
			})
		})
	}

	if( team ){
		team.addEventListener('click', () => {
			const modal = new Modal({
				type: 'team',
			})
			const form = document.createElement('form')
			const title = document.createElement('h3')
			title.classList.add('modal-title')
			title.innerText = 'create team:'
			let clar
			if( is_manager ){
				clar = document.createElement('span')
				clar.innerText = '(team will be automatically assigned you as manager)'
				clar.classList.add('clarification')
			}
			const name = document.createElement('input')
			name.type = 'text'
			name.placeholder = 'team name'
			let man_label 
			let manager
			if( is_admin ){
				man_label = document.createElement('label')
				man_label.innerText = 'manager:'
				manager = document.createElement('select')
				fill_select( manager, 'managers', 'alphabetical', 1, 'surname' )
			}
			const submit = document.createElement('input')
			submit.classList.add('button')
			submit.type = 'submit'
			submit.value = 'create'
			const br = document.createElement('br')
			form.appendChild( title )
			if( is_manager ) form.appendChild( clar )
			form.appendChild( name )
			if( is_admin ){
				form.appendChild( man_label )
				form.appendChild( manager )
			}
			form.appendChild( br )
			form.appendChild( submit )
			modal.content.appendChild( form )
			document.body.appendChild( modal.ele )
			form.addEventListener('submit', e => {
				ui.spinner.show()
				e.preventDefault()
				const n = name.value.trim()
				const m = manager ? manager.value : false
				fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
					type: 'team',
					name: n,
					manager_key: m,
				})
				.then( res => {
					if( res.success ){
						hal('success', 'success', 3000 )
						modal.ele.remove()
					}else{
						ui.reject( res, res.msg || 'failed to create', 3000 )
					}
				})
				.catch( err => {
					ui.reject( err, err.msg || 'failed to create', 3000 )
				})
			})
		})
	}

	if( player ){
		player.addEventListener('click', () => {
			const modal = new Modal({
				type: 'player',
			})
			const form = document.createElement('form')
			const title =document.createElement('h3')
			title.classList.add('modal-title')
			title.innerText = 'add a player:'
			const clar = document.createElement('div')
			clar.classList.add('clarification')
			clar.innerText = '(to assign the player\'s team, use the team\'s page)'
			const name = document.createElement('input')
			name.type = 'text'
			name.placeholder = 'player name'
			const surname = document.createElement('input')
			surname.type = 'text'
			surname.placeholder = 'player last name'
			const position = document.createElement('input')
			position.type = 'text'
			position.placeholder = 'player position (optional)'
			const email = document.createElement('input')
			email.type = 'text'
			email.placeholder = 'player email (optional)'
			const submit = document.createElement('input')
			submit.classList.add('button')
			submit.type = 'submit'
			submit.value = 'create'
			const br = document.createElement('br')
			form.appendChild( title )
			form.appendChild( clar )
			form.appendChild( name )
			form.appendChild( surname )
			form.appendChild( email )
			form.appendChild( position )
			form.appendChild( br )
			form.appendChild( submit )
			modal.content.appendChild( form )
			document.body.appendChild( modal.ele )
			form.addEventListener('submit', e => {
				ui.spinner.show()
				e.preventDefault()
				const n = name.value.trim()
				const s = surname.value.trim()
				const em = email.value.trim()
				const p = position.value.trim()
				fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
					type: 'player',
					name: n,
					surname: s,
					email: em,
					position: p,
				})
				.then( res => {
					if( res.success ){
						hal('success', 'success', 3000 )
						// setTimeout(()=>{
							// window.location.reload()
						// }, 500 )
						modal.ele.remove()
					}else{
						ui.reject( res, res.msg || 'failed to create', 2000 )
					}
				})
				.catch( err => {
					ui.reject( err, err.msg || 'failed to create', 2000 )
				})
			})
		})
	}

}



if( add_team ){
	add_team.addEventListener('click', () => {
		const modal = new Modal({
			type: 'add-team'
		})
		const form = document.createElement('div')
		const title = document.createElement('h3')
		title.classList.add('modal-title')
		title.innerHTML = 'pick a team:'
		const select = document.createElement('select')
		fill_select( select, 'teams', 'alphabetical', 1, 'name')
		const br = document.createElement('br')
		const submit = document.createElement('input')
		submit.type = 'submit'
		submit.classList.add('button')
		submit.value = 'add'
		form.appendChild( title )
		form.appendChild( select )
		form.appendChild( br )
		form.appendChild( submit )
		modal.content.appendChild( form )
		document.body.appendChild( modal.ele )
		submit.addEventListener('click', () => {
			ui.spinner.show()
			fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
				type: 'registration',
				team_key: select.value,
				tourney_key: location.href.substr( location.href.indexOf('?t=') + 3, 1 ),
			})
			.then( res => {
				if( res.success ){
					hal('success', 'success', 3000 )
					setTimeout(()=>{
						window.location.reload()
					}, 500 )
				}else{	
					ui.reject( res, res.msg || 'error creating', 3000 )
				}
			})
			.catch( err => {
				ui.reject( err, err.msg || 'error creating', 3000 )
			})
		})
	})
}



if( add_player ){
	add_player.addEventListener('click', () => {
		const modal = new Modal({
			type: 'add-player'
		})
		const form = document.createElement('div')
		const title = document.createElement('h3')
		title.classList.add('modal-title')
		title.innerHTML = 'add a player to team ' + document.querySelector('#team h3').innerText.replace('team:', '') + ':'
		const select = document.createElement('select')
		fill_select( select, 'players', 'alphabetical', 1, 'surname')
		const br = document.createElement('br')
		const submit = document.createElement('input')
		submit.type = 'submit'
		submit.classList.add('button')
		submit.value = 'add'
		form.appendChild( title )
		form.appendChild( select )
		form.appendChild( br )
		form.appendChild( submit )
		modal.content.appendChild( form )
		document.body.appendChild( modal.ele )
		submit.addEventListener('click', () => {
			ui.spinner.show()
			fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
				type: 'player-registration',
				player_key: select.value,
				team_key: location.href.substr( location.href.indexOf('?t=') + 3, 1 )
			})
			.then( res => {
				if( res.success ){
					hal('success', 'success', 3000 )
					setTimeout(()=>{
						window.location.reload()
					}, 500 )
				}else{	
					ui.reject( res, res.msg || 'error assigning', 3000 )
				}
			})
			.catch( err => {
				ui.reject( err, res.msg || 'error assigning', 3000 )
			})
		})
		document.body.appendChild( modal.ele )
	})
}


if( add_to_team ){
	add_to_team.addEventListener('click', () => {
		const modal = new Modal({
			type: 'add-to-team'
		})
		const form = document.createElement('div')
		const title = document.createElement('h3')
		title.classList.add('modal-title')
		title.innerHTML = 'add player to a team'
		const select = document.createElement('select')
		fill_select( select, 'teams', 'alphabetical', 1, 'name')
		const br = document.createElement('br')
		const submit = document.createElement('input')
		submit.type = 'submit'
		submit.classList.add('button')
		submit.value = 'add'
		form.appendChild( title )
		form.appendChild( select )
		form.appendChild( br )
		form.appendChild( submit )
		modal.content.appendChild( form )
		document.body.appendChild( modal.ele )
		submit.addEventListener('click', () => {
			ui.spinner.show()
			fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
				type: 'player-registration',
				team_key: select.value,
				player_key: location.href.substr( location.href.indexOf('?t=') + 3, 1 )
			})
			.then( res => {
				if( res.success ){
					hal('success', 'success', 3000 )
					setTimeout(()=>{
						window.location.reload()
					}, 500 )
				}else{	
					ui.reject( res, res.msg || 'error assigning', 3000 )
				}
			})
			.catch( err => {
				ui.reject( err, res.msg || 'error assigning', 3000 )
			})
		})
		document.body.appendChild( modal.ele )
	})
}


if( deletes && deletes.length ){
	for( const del of deletes ){
		del.addEventListener('click', e => {
			if( confirm('delete? cannot be undone') ){
				ui.spinner.show()
				fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/delete.php', 'post', {
					type: del.getAttribute('data-type'),
					id: del.getAttribute('data-id'),
				})
				.then( res => {
					if( res.success ){
						hal('success', 'success')
						setTimeout(()=>{
							window.location.reload()
						}, 500)
					}else{
						ui.reject( res, 'err deleting', 3000)
					}
				})
				.catch( err => {
					ui.reject( err, 'err deleting', 3000)
				})
			}
			e.preventDefault()
		})
	}
}


if( reset_request ){
	const querymail = location.href.substr( location.href.indexOf('?e=') + 3 )
	const email = reset_request.querySelector('input[type=email]')
	if( querymail ) email.value = querymail
	reset_request.addEventListener('submit', e => {
		e.preventDefault()
		ui.spinner.show()
		fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/send_reset.php', 'post', {
			email: email.value.trim(),
		})
		.then( res => {
			console.log( res )
			if( res.success ){
				hal('success', 'email sent' + ( res.msg ? '<br>' + res.msg : '' ), env.PRODUCTION ? 3000 : false )
				ui.spinner.hide()
			}else{
				ui.reject( res, res.msg || 'email failed to send', 3000)
			}
		})
		.catch( err => {
			ui.reject( err, err.msg || 'email failed to send', 3000)
		})
	})
}

if( reset_verify ){
	const label = reset_verify.querySelector('label')
	const email = location.href.substr( location.href.indexOf('?e=') + 3 )
	label.innerText = 'reset code for ' + email + ': '
	reset_verify.addEventListener('submit', e => {
		e.preventDefault()
		ui.spinner.show()
		const code = reset_verify.querySelector('input[type=text]')
		fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/set_reset.php', 'post', {
			code: code.value.trim(),
			email: email,
		})
		.then( res => {
			if( res.success ){
				window.location.assign(env.PUBLIC_ROOT + '/server/reset_password.php')
				// hal('success', 'success', 3000)// + ( res.msg ? '<br>' + res.msg : '' ), 3000)
				// ui.spinner.hide()
			}else{
				ui.reject( res, res.msg || 'reset failed', 3000)
			}
		})
		.catch( err => {
			ui.reject( err, err.msg || 'reset failed', 3000)
		})
	})
}

if( reset_password ){
	reset_password.addEventListener('submit', e => {
		e.preventDefault()
		ui.spinner.show()
		fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/set_password.php', 'post', {
			password: reset_password.querySelector('input').value.trim(),
		})
		.then( res => {
			if( res.success ){
				hal('success', 'success', 3000)
				ui.spinner.hide()
			}else{
				ui.reject( res, res.msg || 'reset failed', 3000)
			}
		})
		.catch( err => {
			ui.reject( err, err.msg || 'reset failed', 3000)
		})
	})
}


if( confirm_code ){
	const label = confirm_code.querySelector('label')
	const query_email = location.href.substr( location.href.indexOf('?e=') + 3)
	label.innerText = 'confirm code for ' + query_email + ': '
	confirm_code.addEventListener('submit', e => {
		e.preventDefault()
		ui.spinner.show()
		fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/confirm_code.php', 'post', {
			code: confirm_code.querySelector('input').value.trim(),
			email: query_email,
		})
		.then( res => {
			if( res.success ){
				hal('success', 'success', 3000)
				ui.spinner.hide()
				setTimeout(()=>{
					location.assign( env.PUBLIC_ROOT )
				}, 500)
			}else{
				ui.reject( res, res.msg || 'reset failed', 3000)
			}
		})
		.catch( err => {
			ui.reject( err, err.msg || 'reset failed', 3000)
		})
	})
}

if( edit_tournament ){
	edit_tournament.addEventListener('click', e => {
		tourney_modal( location.href.substr( location.href.indexOf('?t=') + 3 ) )
	})
}

const fill_select = ( select, table, type, direction, key ) => {

	fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/read.php', 'post', {
		table: table,
	})
	.then( res => {
		if( res.success && res.results ){
			const opt1  = document.createElement('option')
			opt1.value = ''
			opt1.innerText = ''
			opt1.selected = true
			select.appendChild( opt1 )
			const sorted = lib.orderby( res.results, type, direction, key )
			for( const result of sorted ){
				const option = document.createElement('option')
				option.value = result.id
				if( key === 'surname' && result.name && result.surname ){
					option.innerText = result.name + ' ' + result.surname
				}else{
					option.innerText = result[key]
				}
				select.appendChild( option )
			}
		}else{
			ui.reject( res, 'error filling managers', 3000 )
		}
	})
	.catch( err => {
		ui.reject( err, 'error filling managers', 3000 )
	})

}