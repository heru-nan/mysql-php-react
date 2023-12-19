import "./App.css";

import React, { useEffect } from "react";
import { useForm } from "react-hook-form";
import "./App.css";

const { validate } = require("rut.js");

export default function App() {
  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm();

  const [regiones, setRegiones] = React.useState([]);
  const [comunas, setComunas] = React.useState([]);
  const [region, setRegion] = React.useState("");
  const [comuna, setComuna] = React.useState("");
  const [candidatos, setCandidatos] = React.useState([]);

  const [isSubmitting, setIsSubmitting] = React.useState(false);
  const [serverResponse, setServerResponse] = React.useState({
    error: false,
    message: "",
  });

  const onSubmit = (data) => {
    data.region = regiones?.find((e) => e.codigo === region)?.nombre;
    data.comuna = comunas?.find((e) => e.codigo === comuna)?.nombre;

    if (!region || !comuna) {
      setServerResponse({
        error: true,
        message: "Debe seleccionar una región y una comuna",
      });
      return;
    }

    if (data.comoSeEntero.length < 2) {
      setServerResponse({
        error: true,
        message: "Debe seleccionar al menos dos opciones",
      });
      return;
    }

    fetch("http://localhost:8000/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
      mode: "cors",
    })
      .then((res) => res.json())
      .then((data) => {
        setIsSubmitting(true);
        setServerResponse(data);

        if (!data.error) reset();
        setIsSubmitting(false);
      })
      .catch((error) => {
        setIsSubmitting(true);
        setServerResponse({
          error: true,
          message: "Error del servidor",
        });
        setIsSubmitting(false);
      });
  };

  useEffect(() => {
    fetch("/dpa/regiones")
      .then((res) => res.json())
      .then((data) => setRegiones(data));

    fetch("http://localhost:8000/candidatos")
      .then((res) => res.json())
      .then((data) => {
        setCandidatos(data.map((e) => e?.nombre));
      });
  }, []);

  const comunaHandler = (region) => {
    fetch(`/dpa/regiones/${region}/comunas`)
      .then((res) => res.json())
      .then((data) => setComunas(data));
  };

  return (
    <div className="container d-flex justify-content-center">
      <div className="m-4">
        <h1>Formulario de Votación</h1>
        <form onSubmit={handleSubmit(onSubmit)}>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="fullName">Nombre y Apellido</label>
            <input
              type="text"
              className="form-control my-2"
              id="fullName"
              {...register("fullName", { required: true })}
            />
            {errors.fullName && (
              <span className="error-message">Este campo es requerido</span>
            )}
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="alias">Alias</label>
            <input
              type="text"
              className="form-control my-2"
              id="alias"
              {...register("alias", {
                required: true,
                minLength: 6,
                pattern: /^(?=.*[a-zA-Z])(?=.*\d).+$/,
              })}
            />
            {errors.alias && errors.alias.type === "required" && (
              <span className="error-message">Este campo es requerido</span>
            )}
            {errors.alias && errors.alias.type === "minLength" && (
              <span className="error-message">
                El alias debe tener al menos 6 caracteres
              </span>
            )}
            {errors.alias && errors.alias.type === "pattern" && (
              <span className="error-message">
                El alias debe contener letras y números
              </span>
            )}
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="rut">RUT</label>
            <input
              type="text"
              className="form-control my-2"
              id="rut"
              {...register("rut", {
                required: true,
                validate: (value) => validate(value),
              })}
            />
            {errors.rut?.type === "required" && (
              <span className="error-message">Este campo es requerido</span>
            )}
            {errors.rut?.type === "validate" && (
              <span className="error-message">RUT invalido</span>
            )}
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="email">Email</label>
            <input
              type="email"
              className="form-control my-2"
              id="email"
              {...register("email", { required: true, pattern: /^\S+@\S+$/i })}
            />
            {errors.email && errors.email.type === "required" && (
              <span className="error-message">Este campo es requerido</span>
            )}
            {errors.email && errors.email.type === "pattern" && (
              <span className="error-message">
                Por favor, ingrese un email válido
              </span>
            )}
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="region">Región</label>
            <select
              className="form-control my-2"
              id="region"
              value={region}
              onChange={(e) => {
                setRegion(e.target.value);
                comunaHandler(e.target.value);
              }}
            >
              <option value="">Seleccione una región</option>
              {regiones.map((region) => (
                <option key={region.codigo} value={region.codigo}>
                  {region.nombre}
                </option>
              ))}
            </select>
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="comuna">Comuna</label>
            <select
              className="form-control my-2"
              id="comuna"
              value={comuna}
              onChange={(e) => setComuna(e.target.value)}
            >
              <option value="">Seleccione una comuna</option>
              {comunas.map((comuna) => (
                <option key={comuna.codigo} value={comuna.codigo}>
                  {comuna.nombre}
                </option>
              ))}
            </select>
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="candidato">Candidato</label>
            <select
              className="form-control my-2"
              id="candidato"
              {...register("candidato", { required: true })}
            >
              <option value="">Seleccione un candidato</option>
              {candidatos.map((candidato) => (
                <option key={candidato} value={candidato}>
                  {candidato}
                </option>
              ))}
            </select>
            {errors.candidato && (
              <span className="error-message">Este campo es requerido</span>
            )}
          </div>
          <div className="form-group mt-3 mb-3">
            <label htmlFor="comoSeEntero">Como se entero de Nosotros</label>
            <div className="m-1">
              <label>
                <input
                  className="mx-2"
                  type="checkbox"
                  value="Web"
                  {...register("comoSeEntero", { required: true })}
                />
                Web
              </label>
            </div>
            <div className="m-1">
              <label>
                <input
                  className="mx-2"
                  type="checkbox"
                  value="TV"
                  {...register("comoSeEntero", { required: true })}
                />
                TV
              </label>
            </div>
            <div className="m-1">
              <label>
                <input
                  className="mx-2"
                  type="checkbox"
                  value="Redes Sociales"
                  {...register("comoSeEntero", { required: true })}
                />
                Redes Sociales
              </label>
            </div>
            <div className="m-1">
              <label>
                <input
                  className="mx-2"
                  type="checkbox"
                  value="Amigo"
                  {...register("comoSeEntero", { required: true })}
                />
                Amigo
              </label>
            </div>
            {errors.comoSeEntero && (
              <span className="error-message">
                Debe seleccionar al menos dos opciones
              </span>
            )}
          </div>
          <input type="submit" value="Votar" className="btn btn-primary" />
        </form>

        {isSubmitting && <div className="my-3">Enviando datos...</div>}
        {serverResponse.error && (
          <div className="my-3 error-message">{serverResponse.message}</div>
        )}
        {!serverResponse.error && serverResponse.message && (
          <div className="my-3">{serverResponse.message}</div>
        )}
      </div>
    </div>
  );
}
