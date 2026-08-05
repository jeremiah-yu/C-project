import { apiClient } from '../../../services/apiClient'

export const fetchEarlyWarnings = async () => {
  const { data } = await apiClient.get('/monitoring/early-warnings')
  return data.data
}

export const fetchMyRisk = async () => {
  const { data } = await apiClient.get('/monitoring/my-risk')
  return data.data
}

export const generateSupportPlan = async (studentId) => {
  const { data } = await apiClient.post(`/monitoring/students/${studentId}/support-plan`)
  return data.data
}
