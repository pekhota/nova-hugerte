import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-hugerte-editor', IndexField)
  app.component('detail-hugerte-editor', DetailField)
  app.component('form-hugerte-editor', FormField)
})
