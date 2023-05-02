const itemsGallery = document.querySelectorAll('.gallery-sidebar__item'),
	sumGallery = document.querySelector('#sum-gallery'),
	openGalleryNum = document.querySelector('#open-gallery'),
	mainPhoto = document.querySelector('.gallery-img__img'),
	prevBtn = document.querySelector('#prev-gallery'),
	nextBtn = document.querySelector('#next-gallery')

sumGallery.innerHTML = itemsGallery?.length

function getActive(e) {
	e.classList.add('item-gall-active')
}
function getNewImage(link) {
	mainPhoto.src = link
}
function removeFavorite() {
	const activeElement = document.querySelector('.item-gall-active')
	activeElement?.classList.remove('item-gall-active')
}
function getItemImg(e) {
	return e.querySelector('img')
}
itemsGallery?.forEach((e, i) =>
	e.addEventListener('click', () => {
		removeFavorite()
		const img = getItemImg(e)
		getNewImage(img.src)
		getActive(e)
		openGalleryNum.innerHTML = i + 1
	})
)

prevBtn?.addEventListener('click', () => {
	const openGalleryNum = document.querySelector('#open-gallery')
	removeFavorite()
	const num = Number(openGalleryNum.textContent)
	if (num >= 2) {
		const open = num - 1
		const itemOpen = itemsGallery[open]
		openGalleryNum.textContent = open
		getActive(itemOpen)
		getNewImage(getItemImg(itemOpen).src)
	}
})
nextBtn?.addEventListener('click', () => {
	const openGalleryNum = document.querySelector('#open-gallery')
	removeFavorite()
	const num = Number(openGalleryNum.textContent)
	if (num !== itemsGallery.length) {
		const open = num + 1
		const itemOpen = itemsGallery[open]
		openGalleryNum.textContent = open
		getActive(itemOpen)
		getNewImage(getItemImg(itemOpen).src)
	}
})

//open

const openItems = document.querySelector('.open-items')
const openGallImage = document.querySelector('.image-open__img')
const nextOpenGall = document.querySelector('#next-gallery-open')
const prevOpenGall = document.querySelector('#prev-gallery-open')
const closeBtnOpen = document.querySelector('.gallery-open__close')
const windowOpen = document.querySelector('.gallery-open')
const btnWindowOpen = document.querySelector('.gallery-control-buttons__btn')
itemsGallery?.forEach((e, i) => {
	if (openItems) {
		const link = getItemImg(e)
		openItems.innerHTML += `
		<li class="open-items__item swiper-slide">
					<img id="gall-${i}" src=${link.src} alt="image" class="open-items__img">
				</li>`
	}
})

openItems.addEventListener('click', event => {
	const ell = event.target
	const active = document.querySelector('.gall-active-ell')
	if (ell.classList.contains('open-items__img')) {
		active?.classList.remove('gall-active-ell')
		ell.classList.add('gall-active-ell')
		openGallImage.src = ell.src
		openGallImage.id = ell.id
	}
})
nextOpenGall?.addEventListener('click', () => {
	const openGallImage = document.querySelector('.image-open__img')
	const num = Number(openGallImage.id.replace('gall-', ''))
	const items = document.querySelectorAll('.open-items__img')
	const active = document.querySelector('.gall-active-ell')
	if (num + 1 != items.length) {
		active?.classList.remove('gall-active-ell')
		const item = items[num + 1]
		openGallImage.src = item.src
		openGallImage.id = item.id
		item.classList.add('gall-active-ell')
	}
})
prevOpenGall?.addEventListener('click', () => {
	const openGallImage = document.querySelector('.image-open__img')
	const num = Number(openGallImage.id.replace('gall-', ''))
	const items = document.querySelectorAll('.open-items__img')
	const active = document.querySelector('.gall-active-ell')
	if (num) {
		active?.classList.remove('gall-active-ell')
		const item = items[num - 1]
		openGallImage.src = item.src
		openGallImage.id = item.id
		item.classList.add('gall-active-ell')
	}
})
closeBtnOpen?.addEventListener('click', () => {
	windowOpen.classList.toggle('open-window')
})
btnWindowOpen?.addEventListener('click', () => {
	const num = document.querySelector('#open-gallery')
	const active = document.querySelector('.item-gall-active')
	const link = getItemImg(active)
	openGallImage.src = link.src
	windowOpen.classList.toggle('open-window')
	openGallImage.id = 'gall-' + (Number(num?.textContent )- 1)
	console.log('gall-' + num?.textContent)
})

const scrollBtn = document.querySelector('.gallery-control__btn')
const sidebarItems = document.querySelector('.gallery-sidebar')

scrollBtn?.addEventListener('click', () => {
	const targetPosition = sidebarItems.scrollTop + 50 // позиція, до якої потрібно прокрутити
	const startPosition = sidebarItems.scrollTop
	const distance = targetPosition - startPosition
	const duration = 400 // час анімації в мілісекундах
	let start = null

	function step(timestamp) {
		if (!start) start = timestamp
		const progress = timestamp - start
		const percentage = Math.min(progress / duration, 1)
		const easing = easeInOutQuad(percentage)
		sidebarItems.scrollTop = startPosition + distance * easing
		if (progress < duration) {
			window.requestAnimationFrame(step)
		}
	}

	window.requestAnimationFrame(step)
})

function easeInOutQuad(x) {
	return x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2
}

if (window.innerWidth < 1200) {
	const progress = document.querySelector('.progress-swipe')
	const sum = document.querySelector('.num-swipe')
	sum.innerHTML = itemsGallery?.length
	var mySwiper = new Swiper('.gallery-sidebar', {
		slidesPerView: 1,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		scrollbar: {
			el: '.swiper-scrollbar-van',
			hide: true,
		},
		on: {
			slideChange: function () {
				progress.innerHTML = Number(this.activeIndex) + 1
			},
		},
	})
	var mySwiper = new Swiper('.open-items-swiper', {
		slidesPerView: 'auto',
		scrollbar: {
			el: '.swiper-scrollbar-two',
			hide: false,
		},
	})
	const imagesItemsMin = document.querySelectorAll('.gallery-sidebar__image')
	imagesItemsMin.forEach((e, i) =>
		e.addEventListener('click', () => {
			openGallImage.src = e.src
			openGallImage.id = 'gall-' + i
			windowOpen.classList.add('open-window')
		})
	)
}
