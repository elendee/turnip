import { Modal } from './Modal.js?v=6'
import fetch_wrap from './fetch_wrap.js?v=6'
// import * as lib from './lib.js?v=6'
import hal from './hal.js?v=6'
import env from './env.js?v=6'
import nav from './nav.js?v=6'

const create = document.querySelector('#create')
const add_team = document.querySelector('#add-team .button')
const add_player = document.querySelector('#add-player .button')
const deletes = document.querySelectorAll('.delete')

nav()

const is_manager = document.querySelector('body.role-manager') ? true : false
const is_admin = document.querySelector('body.role-admin') ? true : false


if( create ){

	const tourney = document.querySelector('#create .tournament')
	const manager = document.querySelector('#create .team-manager')
	const team = document.querySelector('#create .team')
	const player = document.querySelector('#create .player')

	if( tourney ){
		tourney.addEventListener('click', () => {
			const modal = new Modal({
				type: 'tournament',
			})
			const form = document.createElement('form')
			const title = document.createElement('h3')
			title.classList.add('modal-title')
			title.innerText = 'create tournament:'
			const name = document.createElement('input')
			name.type = 'text'
			name.placeholder = 'tournament name'
			const date = document.createElement('input')
			date.type = 'text'
			date.placeholder = 'tournament date'
			const location = document.createElement('input')
			location.type = 'text'
			location.placeholder = 'tournament location'
			const submit = document.createElement('input')
			submit.classList.add('button')
			submit.type = 'submit'
			submit.value = 'create'
			const br = document.createElement('br')
			form.appendChild( title )
			form.appendChild( name )
			form.appendChild( date )
			form.appendChild( location )
			form.appendChild( br )
			form.appendChild( submit )
			modal.content.appendChild( form )
			document.body.appendChild( modal.ele )
			form.addEventListener('submit', e => {
				e.preventDefault()
				const n = name.value.trim()
				const d = date.value.trim()
				const l = location.value.trim()
				fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
					type: 'tournament',
					date: d,
					location: l,
					name: n,
				})
				.then( res => {
					if( res.success ){
						hal('success', 'success', 3000 )
						setTimeout(()=>{
							window.location.reload()
						}, 500 )
					}else{
						console.log( res )
						hal('error', res.msg || 'failed to create', 2000 )
					}
				})
				.catch( err => {
					console.log( err )
					hal('error', err.msg || 'failed to create', 2000 )
				})
			})
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
			name.placeholder = 'manager name'
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
			form.appendChild( email )
			// form.appendChild( password )
			form.appendChild( br )
			form.appendChild( submit )
			modal.content.appendChild( form )
			document.body.appendChild( modal.ele )
			form.addEventListener('submit', e => {
				e.preventDefault()
				const n = name.value.trim()
				const em = email.value.trim()
				// const p = password.value.trim()
				// fetch_wrap('/create', 'post', {
				fetch_wrap( env.PUBLIC_ROOT + '/server/ajax/create.php', 'post', {
					type: 'manager',
					name: n,
					email: em,
					// password: p,
				})
				.then( res => {
					if( res.success ){
						hal('success', 'success', 3000 )
						modal.ele.remove()
					}else{
						console.log( res )
						hal('error', res.msg || 'failed to create', 2000 )
					}
				})
				.catch( err => {
					console.log( err )
					hal('error', err.msg || 'failed to create', 2000 )
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
				fill_select( manager, 'managers' )			
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
				e.preventDefault()
				const n = name.value.trim()
				const m = manager ? manager.value : false
				// fetch_wrap('/create', 'post', {
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
						console.log( res )
						hal('error', res.msg || 'failed to create', 2000 )
					}
				})
				.catch( err => {
					console.log( err )
					hal('error', err.msg || 'failed to create', 2000 )
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
						console.log( res )
						hal('error', res.msg || 'failed to create', 2000 )
					}
				})
				.catch( err => {
					console.log( err )
					hal('error', err.msg || 'failed to create', 2000 )
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
		fill_select( select, 'teams')
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
					console.log( res )
					hal('error', res.msg || 'error creating', 3000 )
				}
			})
			.catch( err => {
				hal('error', err.msg || 'error creating', 3000 )
				console.log( err )
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
		fill_select( select, 'players')
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
					console.log( res )
					hal('error', res.msg || 'error assigning', 3000 )
				}
			})
			.catch( err => {
				hal('error', err.msg || 'error assigning', 3000 )
				console.log( err )
			})
		})
		document.body.appendChild( modal.ele )
	})
}


if( deletes && deletes.length ){
	for( const del of deletes ){
		del.addEventListener('click', e => {
			if( confirm('delete? cannot be undone') ){
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
						hal('error', 'err deleting', 3000)
						console.log( res )
					}
				})
				.catch( err => {
					hal('error', 'err deleting', 3000)
					console.log( err )
				})
			}
			e.preventDefault()
		})
	}
}



const fill_select = ( select, table ) => {

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
			for( const result of res.results ){
				const option = document.createElement('option')
				option.value = result.id
				option.innerText = result.name
				select.appendChild( option )
			}
		}else{
			hal('error', 'error filling managers', 3000 )
			console.log( res )
		}
	})
	.catch( err => {
		console.log( err )
	})

}