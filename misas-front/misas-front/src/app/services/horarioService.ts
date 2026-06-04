import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { ApiResponse } from "../interfaces/ApiResponse";

@Injectable({
    providedIn: 'root',
})
export class HorarioService {
    private apiURL = "http://localhost/api/horarios";

    constructor(private http: HttpClient) {}

    getAll() {
        return this.http.get<ApiResponse<any[]>>(this.apiURL);
    }

    getAllDescriptive() {
        return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/descriptivos`);
    }

    getById(id: number) {
        return this.http.get<ApiResponse<any>>(`${this.apiURL}/${id}`);
    }

    getByHora(hora: string) {
        return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/hora/${hora}`);
    }

    getByDia(dia: string) {
        return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/dia/${dia}`);
    }

    getByActivo(activo: boolean) {
        return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/activo/${activo}`);
    }

    getByLocacionId(locacionId: number) {
        return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/locacion/${locacionId}`);
    }

    search(hora?: string, dia?: number, ciudadId?: number) {
        let queryParams = [];
        if (hora) queryParams.push(`hora=${encodeURIComponent(hora)}`);
        if (dia !== undefined && dia !== null) queryParams.push(`diasemana=${dia}`);
        if (ciudadId !== undefined && ciudadId !== null) queryParams.push(`ciudadid=${ciudadId}`);
        return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/buscar?${queryParams.join('&')}`);
    }

    create(horario: any) {
        return this.http.post<ApiResponse<any>>(this.apiURL, horario);
    }

    update(id: number, horario: any) {
        console.info('Enviando solicitud de actualización para horario con ID:', id, 'y datos:', horario);
        return this.http.put<ApiResponse<any>>(`${this.apiURL}/${id}`, horario);
    }

    delete(id: number) {
        return this.http.delete<ApiResponse<any>>(`${this.apiURL}/${id}`);
    }
}