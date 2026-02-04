<script setup lang="ts">
import { Form, Head, router, useForm, usePage } from '@inertiajs/vue3';
//import { vMaska } from 'maska/vue';
import { onMounted } from 'vue';
//import { toast } from 'vue-sonner';

import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import vendedores from '@/routes/vendedores';

const page = usePage();
const props = page.props as unknown as {
    idVendedor: number | null;
    vendedor?: Record<string, any>;
};

const vendedor = props.vendedor;

// checa explicitamente null/undefined e mostra erro

onMounted(() => {
    if (props.idVendedor != null && !vendedor) {
        router.visit(vendedores.listar().url);
        // toast.error('Vendedor não encontrado.');
    }
});

function onComissaoInput(e: Event) {
    const el = e.target as HTMLInputElement;
    let v = el.value;

    // aceita vírgula como separador decimal
    v = v.replace(',', '.');

    // apenas números e ponto
    v = v.replace(/[^\d.]/g, '');

    // apenas UM ponto
    const dotIndex = v.indexOf('.');
    if (dotIndex !== -1) {
        v = v.slice(0, dotIndex + 1) + v.slice(dotIndex + 1).replace(/\./g, '');
    }

    // se começa com ponto, prefixa 0
    if (v.startsWith('.')) {
        v = '0' + v;
    }

    // limita a 1 casa decimal
    if (v.includes('.')) {
        const [intPart, decPart] = v.split('.');
        v = intPart + '.' + decPart.slice(0, 1);
    }

    // bloqueia valores acima de 100
    const n = Number(v);
    if (!isNaN(n) && n > 100) {
        v = '100';
    }

    // se for exatamente 100, não permite ponto
    if (v === '100.' || v.startsWith('100.')) {
        v = '100';
    }

    form.comissao = v;
}

function onComissaoBlur() {
    if (!form.comissao) return;

    let n = Number(form.comissao.replace(',', '.'));

    if (isNaN(n)) {
        form.comissao = '';
        return;
    }

    // clamp final de segurança
    n = Math.max(0, Math.min(100, n));

    // remove .0 desnecessário
    form.comissao = Number.isInteger(n) ? String(n) : n.toFixed(1);
}

const form = useForm({
    nome: vendedor?.user?.name ?? '',
    email: vendedor?.user?.email ?? '',
    cpf: vendedor?.cpf ?? '',
    comissao: vendedor?.comissao ?? '',
    cep: vendedor?.endereco?.cep ?? '',
    rua: vendedor?.endereco?.rua ?? '',
    numero: vendedor?.endereco?.numero ?? '',
    complemento: vendedor?.endereco?.complemento ?? '',
    bairro: vendedor?.endereco?.bairro ?? '',
    cidade: vendedor?.endereco?.cidade ?? '',
    estado: vendedor?.endereco?.estado ?? '',
});

function viaCepLookup(cep: string) {
    cep = cep.replace(/\D/g, ''); // Remove non-digit characters
    fetch(https://viacep.com.br/ws/${cep}/json/)
        .then((response) => response.json())
        .then((data) => {
            form.rua = data.logradouro || '';
            form.bairro = data.bairro || '';
            form.cidade = data.localidade || '';
            form.estado = data.uf || '';
        })
        .catch((error) => {
            console.error('Erro ao buscar CEP:', error);
        });
}

function submit() {
    if (props.idVendedor != null) {
        // edição
        form.put(vendedores.update(props.idVendedor).url, {
            onSuccess: () => {
                toast.success('Vendedor atualizado com sucesso.');
            },
            onError: (errors) => {
                console.log('Erros:', errors);
            },
        });
        return;
    }

    // ajuste a URL para a rota correta do backend, ex: '/vendedores' ou use Wayfinder/url gerada
    form.post(vendedores.criar().url, {
        onSuccess: () => {
            // Sucesso - formulário será resetado automaticamente
            toast.success('Vendedor criado com sucesso.');
        },
        onError: (errors) => {
            // Erros de validação
            console.log('Erros:', errors);
        },
    });
}
</script>

<template>
    <Head title="Vendedor" />

    <AppLayout>
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Heading title="Vendedores" description="Cria vendedores" />
            <div class="md:grid-cols 4 grid-cols-1">
                <div
                    class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
                >
                    <Form>
                        <Heading title="Informações pessoais" />

                        <div class="mb-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="grid gap-2">
                                <Label for="nome">Nome</Label>
                                <!--<Input
                                    
                                    id="nome"
                                    type="text"
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="nome"
                                    name="nome"
                                    placeholder="Nome Completo"
                                />-->
                                <!-- <InputError :message="form.errors.nome" />-->
                            </div>

                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <!--<Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    :tabindex="2"
                                    autocomplete="email"
                                    name="email"
                                    placeholder="email@exemplo.com"
                                />-->
                                <Input
                                    id="email"
                                   
                                    type="email"
                                    :tabindex="2"
                                    autocomplete="email"
                                    name="email"
                                    placeholder="email@exemplo.com"
                                />
                                <!--<InputError :message="form.errors.email" />-->
                                
                            </div>

                            <div class="grid gap-2">
                                <Label for="cpf">CPF</Label>
                                <!--<Input
                                    v-model="form.cpf"
                                    id="cpf"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="cpf"
                                    name="cpf"
                                    placeholder="000.000.000-00"
                                    v-maska="'###.###.###-##'"
                                />
                                <InputError :message="form.errors.cpf" />-->
                                <Input
                                    v-model="form.cpf"
                                    id="cpf"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="cpf"
                                    name="cpf"
                                    placeholder="000.000.000-00"
                                    v-maska="'###.###.###-##'"
                                />
                                <InputError :message="form.errors.cpf" />
                            </div>
                        </div>
                        <Separator />
                        <Heading title="Informações adicionais" class="mt-4" />
                        <div
                            class="mt-4 mb-4 grid grid-cols-1 gap-6 md:grid-cols-3"
                        >
                            <div class="grid gap-2">
                                <Label for="comissao">Comissão</Label>
                                <div class="relative">
                                    <Input
                                        v-model="form.comissao"
                                        type="text"
                                        class="pr-8"
                                        @blur="onComissaoBlur"
                                        @input="onComissaoInput"
                                        id="comissao"
                                        placeholder="0.00%"
                                    />
                                    <span
                                        class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-muted-foreground"
                                    >
                                        %
                                    </span>
                                </div>
                                <InputError :message="form.errors.comissao" />
                            </div>
                        </div>
                        <Separator />
                        <Heading title="Endereço" class="mt-4" />
                        <div
                            class="mt-4 mb-4 grid grid-cols-1 gap-6 md:grid-cols-3"
                        >
                            <div class="grid gap-2">
                                <Label for="cep">CEP</Label>
                                <Input
                                    @blur="viaCepLookup(form.cep)"
                                    v-model="form.cep"
                                    id="cep"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="cep"
                                    name="cep"
                                    placeholder="insira seu CEP"
                                    v-maska="'#####-###'"
                                />
                                <InputError :message="form.errors.cep" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="rua">Rua</Label>
                                <Input
                                    v-model="form.rua"
                                    id="rua"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="rua"
                                    name="rua"
                                    placeholder="Insira sua rua"
                                />
                                <InputError :message="form.errors.rua" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="numero">Numero</Label>
                                <Input
                                    v-model="form.numero"
                                    id="numero"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="numero"
                                    name="numero"
                                    placeholder="Insira sua numero"
                                />
                                <InputError :message="form.errors.numero" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="complemento">Complemento</Label>
                                <Input
                                    v-model="form.complemento"
                                    id="complemento"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="complemento"
                                    name="complemento"
                                    placeholder="Insira sua complemento"
                                />
                                <InputError
                                    :message="form.errors.complemento"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="bairro">Bairro</Label>
                                <Input
                                    v-model="form.bairro"
                                    id="bairro"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="bairro"
                                    name="bairro"
                                    placeholder="Insira sua bairro"
                                />
                                <InputError :message="form.errors.bairro" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="cidade">Cidade</Label>
                                <Input
                                    v-model="form.cidade"
                                    id="cidade"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="cidade"
                                    name="cidade"
                                    placeholder="Insira sua cidade"
                                />
                                <InputError :message="form.errors.cidade" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="estado">Estado</Label>
                                <Input
                                    v-model="form.estado"
                                    id="estado"
                                    type="text"
                                    :tabindex="2"
                                    autocomplete="estado"
                                    name="estado"
                                    placeholder="Insira sua estado"
                                />
                                <InputError :message="form.errors.estado" />
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-5">
                            <Button
                                type="submit"
                                class="mt-2 w-full bg-accent hover:bg-accent/90"
                                tabindex="5"
                                data-test="register-user-button"
                            >
                                Salvar Vendedor
                            </Button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>