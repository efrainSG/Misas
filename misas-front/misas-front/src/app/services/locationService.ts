import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ApiResponse } from '../interfaces/ApiResponse';

@Injectable({
  providedIn: 'root',
})
export class LocationService {
  private apiURL = "http://localhost/api/locaciones";
  
  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<ApiResponse<any[]>>(this.apiURL);
  }

  getAllDescriptive() {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/descriptivas`);
  }
  
  getById(id: number) {
    return this.http.get<ApiResponse<any>>(`${this.apiURL}/${id}`);
  }

  getByNombre(nombre: string) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/nombre/${nombre}`);
  }

  getByColonia(coloniaId: number) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/byColonia/${coloniaId}`);
  }

  getByTipo(tipoLocacionId: number) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/byTipo/${tipoLocacionId}`);
  }

  getHorariosByLocacionId(locacionId: number) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/${locacionId}/horarios`);
  }

  getByTipoAndColonia(tipoLocacionId: number, coloniaId: number) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/byTipoAndColonia/${tipoLocacionId}/${coloniaId}`);
  }

  create(location: any) {
    return this.http.post<ApiResponse<any>>(this.apiURL, location);
  }

  update(id: number, location: any) {
    return this.http.put<ApiResponse<any>>(`${this.apiURL}/${id}`, location);
  }

  delete(id: number) {
    return this.http.delete<ApiResponse<any>>(`${this.apiURL}/${id}`);
  }
}
