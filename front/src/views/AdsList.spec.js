import { mount } from '@vue/test-utils'
import AdsList from './AdsList.vue'
import { describe, it, expect } from 'vitest'

describe('AdsList', () => {
  it('renderuje tytuł', () => {
    const wrapper = mount(AdsList, {
      global: {
        mocks: {
          axios: { get: () => Promise.resolve({ data: [] }) }
        }
      }
    })
    expect(wrapper.text()).toContain('Lista ogłoszeń')
  })
}) 