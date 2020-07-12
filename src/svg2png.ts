window.addEventListener('load', loadHandler, false)

function loadHandler() {
  let svgFile = document.querySelector('#svg-file') as HTMLInputElement
  let main = document.querySelector('#main') as HTMLDivElement

  svgFile.addEventListener('change', function () {
    let files = this.files as FileList
    svg2png(files)
  })

  dropHandler()
}

function svg2png(files: FileList) {
  let main = document.querySelector('#main') as HTMLDivElement

  let fReader = new FileReader()
  loadImageFile(files[0])

  console.log(files)

  fReader.onload = (oFREvent) => {
    let image = new Image()
    if (oFREvent.target) {
      image.src = (oFREvent.target as any).result as string

      image.onload = () => {
        let canvas = document.createElement('canvas') as HTMLCanvasElement
        let ctx = canvas.getContext('2d') as CanvasRenderingContext2D
        console.log(image.width, image.height)
        canvas.width = image.width
        canvas.height = image.height
        ctx.drawImage(image, 0, 0, image.width, image.height)

        // Now is done
        let png = canvas.toDataURL('image/png')

        let a = document.createElement('a') as HTMLAnchorElement
        main.appendChild(a)
        a.href = png
        a.download = files[0].name + '.png'
        a.click()
        main.removeChild(a)
      }
    }
    main.appendChild(image)
  }

  function loadImageFile(file: any) {
    fReader.readAsDataURL(file)
  }
}

function dropHandler() {
  let dropRegion = document.querySelector('#drag-svg-file') as HTMLDivElement

  dropRegion.addEventListener('click', function () {
    let svgFile = document.querySelector('#svg-file') as HTMLInputElement
    svgFile.click()
  })

  document.addEventListener('drop', (e) => {
    e.preventDefault()

    let target = e.target as HTMLElement
    if (target !== dropRegion) return

    let files = e!.dataTransfer!.files
    svg2png(files as FileList)
  })
}

window.addEventListener('dragover', function (e) {
  e.preventDefault()
})
