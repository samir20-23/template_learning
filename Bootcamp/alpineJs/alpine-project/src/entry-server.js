import { renderToWebStream } from 'vue/server-renderer'
import { createApp } from './main'

/**
 * @param {string} _url
 */
export function render(_url) {
  const { app } = createApp()

  // passing SSR context object which will be available via useSSRContext()
  // @vitejs/plugin-vue injects code into a component's setup() that registers
  // itself on ctx.modules. After the render, ctx.modules would contain all the
  // components that have been instantiated during this render call.
  const ctx = {}
  const stream = renderToWebStream(app, ctx)

  return { stream }
}
