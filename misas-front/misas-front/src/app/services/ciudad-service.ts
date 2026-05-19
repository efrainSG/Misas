import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ApiResponse } from '../interfaces/ApiResponse';

@Injectable({
  providedIn: 'root',
})
export class CiudadService {
  private apiURL = "http://localhost/api/ciudades";

  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<ApiResponse<any[]>>(this.apiURL);
  }

  getById(id: number) {
    return this.http.get<ApiResponse<any>>(`${this.apiURL}/${id}`);
  }

  getByNombre(nombre: string) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/nombre/${nombre}`);
  }

  create(ciudad: any) {
    return this.http.post<ApiResponse<any>>(this.apiURL, ciudad);
  }

  update(id: number, ciudad: any) {
    return this.http.put<ApiResponse<any>>(`${this.apiURL}/${id}`, ciudad);
  }

  delete(id: number) {
    return this.http.delete<ApiResponse<any>>(`${this.apiURL}/${id}`);
  }
}
