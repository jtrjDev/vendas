<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogTrigger, DialogClose, } from '@/components/ui/dialog';
import vendedores from '@/routes/vendedores';
import { toast } from 'vue-sonner';

const props = defineProps<{
    vendedor: Record<string, any>;
}>();

const vendedor = props.vendedor;

function removeVendedor(){
    router.delete(vendedores.remove(vendedor.id_vendedor),{
        onSuccess: () => {
                    
                    toast.success("Vendedor removido com sucesso !");
                },
                onError: () => {
                  
                    toast.error('erro ao remover vendedor!');
                    
                },
    })
}


</script>

<template>
    <div class="flex gap-2">
        <Link :href="vendedores.persistir(vendedor.id_vendedor)">
            <Button class="bg-yellow-400 dark:bg-white">
                <!--<Button class="bg-accent  hover:bg-accent/90">-->
                <Icon name="plus" />
                Editar vendedor
            </Button>
        </Link>
        <Dialog>
            <DialogTrigger>
                <Button class="bg-red-700 hover:bg-red-700/90">
                    <span>Remover</span>
                </Button>
            </DialogTrigger>
            <DialogContent>
                <span>
                    Tem certeza que deseja remover o vendedor:
                    {{ vendedor.user.name }}?
                </span>
                <div class="flex justify-end gap-2">

                    <Button class="bg-red-700 hover:bg-red-700/90 text-white" @click="removeVendedor">
                        Remover Vendedor
                    </Button>
                    <DialogClose>
                        <Button>
                            Cancelar
                        </Button>
                    </DialogClose>
                </div>
            </DialogContent>
        </Dialog>

    </div>
</template>
<style scoped></style>